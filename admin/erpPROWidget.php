<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

/**
 * Widget class.
 *
 * @package Easy_Related_Posts
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROWidget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(erpPRODefaults::erpPROWidgetOptionsArrayName, 'Easy Related Posts PRO', array(
            'description' => __('Show related posts ')
                ), array(
            'width' => 500
        ));
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args
     *        	Widget arguments.
     * @param array $instance
     *        	Saved values from database.
     * @since 1.0.0
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     */
    public function widget($args, $instance) {
        global $post;
        // get instance of main plugin
        $plugin = easyRelatedPostsPRO::get_instance();
        // check if it's time to take action
        if (!is_single($post->ID)) {
            return;
        }
        
        if ($plugin->isInExcludedPostTypes($post) || $plugin->isInExcludedTaxonomies($post)) {
            return;
        }
        // Fill missing options
        if (empty($instance)) {
            $instance = erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;
        } else {
            $instance = $instance + erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;
        }

        erpPROPaths::requireOnce(erpPROPaths::$erpProRelated);
        erpPROPaths::requireOnce(erpPROPaths::$erpPROMainOpts);
        erpPROPaths::requireOnce(erpPROPaths::$erpPROWidOpts);

        $mainOpts = new erpPROMainOpts();

        $instance ['tags'] = $mainOpts->getTags();
        $instance ['categories'] = $mainOpts->getCategories();
        $instance ['postTypes'] = $mainOpts->getPostTypes();

        $widOpts = new erpPROWidOpts($instance);

        // Get related
        $relatedObj = erpProRelated::get_instance($widOpts);
        $wpQ = $relatedObj->getRelated($post->ID);
        // If we have some posts to show
        if (!$wpQ->have_posts()) {
            $this->displayEmptyWidget($args, $instance);
        }
        erpPaths::requireOnce(erpPaths::$VPluginThemeFactory);
        VPluginThemeFactory::registerThemeInPathRecursive(erpPaths::getAbsPath(erpPaths::$widgetThemesFolder), $instance ['dsplLayout']);
        $theme = VPluginThemeFactory::getThemeByName($instance ['dsplLayout']);
        if (!$theme) {
            return $this->displayEmptyWidget($args, $instance);
        }

        $theme->setOptions($instance);
        $theme->formPostData($wpQ, $widOpts, $relatedObj->getRatingsFromRelDataObj());
        $content = $theme->renderW($this->number);

        // display rel content
        echo $args ['before_widget'];
        echo $args ['before_title'] . $instance ['title'] . $args ['after_title'];
        echo $content;
        echo $args ['after_widget'];
    }

    /**
     * Back-end widget form.
     * Outputs the options form on admin
     *
     * @see WP_Widget::form()
     *
     * @param array $instance
     *        	Previously saved values from database.
     * @since 1.0
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     */
    public function form($instance) {
        // Fill missing options
        if (empty($instance)) {
            $instance = erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;
        } else {
            $instance = $instance + erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;
        }

        // Pass it to viewData
        erpPROPaths::requireOnce(erpPROPaths::$erpPROView);
        $widgetInstance = $this;
        $optionsTemplate = EPR_PRO_BASE_PATH . 'admin/views/widgetSettings.php';
        erpPROView::render($optionsTemplate, array(
            'options' => $instance,
            'widgetInstance' => $widgetInstance
                ), true);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance
     *        	Values just sent to be saved.
     * @param array $old_instance
     *        	Previously saved values from database.
     * @return array Updated safe values to be saved.
     * @since 1.0.0
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     */
    public function update($new_instance, $old_instance) {
        /* #? Verify nonce */
        if (!isset($_POST ['erpPRO_meta_box_nonce']) || !wp_verify_nonce($_POST ['erpPRO_meta_box_nonce'], 'erpPRO_meta_box_nonce')) {
            return;
        }
        erpPROPaths::requireOnce(erpPROPaths::$erpPROWidOpts);
        erpPROPaths::requireOnce(erpPROPaths::$erpPROWidTemplates);

        // get an instance to validate options
        $widOpts = new erpPROWidOpts($old_instance);
        // validate wid options
        $widOptsValidated = $widOpts->saveOptions($new_instance, $old_instance);
        // validate template options
        $template = new erpPROWidTemplates();
        $template->load($new_instance ['dsplLayout']);

        if ($template->isLoaded()) {
            $tempalteOptionsValidated = $template->saveTemplateOptions($new_instance);
        } else {
            $tempalteOptionsValidated = array();
        }
        // save updated options
        return array_merge($widOptsValidated, $tempalteOptionsValidated);
    }

    /**
     * Just echoes an empty widget.
     *
     * @param array $args
     * @param array $instance
     *
     * @since 1.0.0
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     */
    private function displayEmptyWidget($args, $instance) {
        if (!$instance ['hideIfNoPosts']) {
            echo $args ['before_widget'];
            echo $args ['before_title'] . $instance ['title'] . $args ['after_title'];
            echo 'No related posts found';
            echo $args ['after_widget'];
        }
    }

}
