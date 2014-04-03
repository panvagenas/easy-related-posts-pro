<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Widget class.
 *
 * @package Easy_Related_Posts
 * @author Your Name <email@example.com>
 */
class erpPROWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct( ) {
		parent::__construct( erpPRODefaults::erpPROWidgetOptionsArrayName, 'Easy Related Posts PRO', array (
				'description' => __( 'Show related posts ' )
		), array (
				'width' => 400
		) );
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
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 */
	public function widget( $args, $instance ) {
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' started' );
		global $post;
		// get instance of main plugin
		$plugin = easyRelatedPostsPRO::get_instance();
		// check if it's time to take action
		if ( is_single( $post->ID ) ) {
			if (($plugin->isInExcludedPostTypes( $post ) && $instance['ptypeExclude']) || ($plugin->isInExcludedTaxonomies( $post ) && $instance['taxExclude'])) {
				$this->displayEmptyWidget($args, $instance);
				return;
			}
			// Fill missing options
			if ( empty( $instance ) ) {
				$instance = erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;
			} else {
				$instance = $instance + erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;
			}

			erpPROPaths::requireOnce( erpPROPaths::$erpProRelated );
			erpPROPaths::requireOnce( erpPROPaths::$erpPROMainOpts );
			erpPROPaths::requireOnce(erpPROPaths::$erpPROWidOpts);

			$mainOpts = new erpPROMainOpts();
			$widOpts = new erpPROWidOpts($instance);

			// Check if we have to exclude taxos or post types
			if ( isset( $new_instance [ "taxExclude" ] ) && $new_instance [ "taxExclude" ] ) {
				$instance [ 'tags' ] = $mainOpts->getValue( 'tags' );
				$instance [ 'categories' ] = $mainOpts->getValue( 'categories' );
			} else {
				$instance [ 'tags' ] = array ();
				$instance [ 'categories' ] = array ();
			}
			if ( isset( $new_instance [ "ptypeExclude" ] ) && $new_instance [ "ptypeExclude" ] ) {
				$instance [ 'postTypes' ] = $mainOpts->getValue( 'postTypes' );
			} else {
				$instance [ 'postTypes' ] = array ();
			}
			// Get related
			$relatedObj = erpProRelated::get_instance( $widOpts );
			$wpQ = $relatedObj->getRelated( $post->ID );
			// If we have some posts to show
			if ( $wpQ->have_posts() ) {
				// Get template instance for the specific widget number
				erpPROPaths::requireOnce( erpPROPaths::$erpPROWidTemplates );
				$template = new erpPROWidTemplates( $this->number );
				// load template
				$template->load( $instance [ 'dsplLayout' ] );
				// If template isn't found display empty widget
				if ( !$template->isLoaded() ) {
					return $this->displayEmptyWidget( $args, $instance );
				}
				// else display rel content
				echo $args [ 'before_widget' ];
				echo $args [ 'before_title' ] . $instance [ 'title' ] . $args [ 'after_title' ];
				echo $template->display( $wpQ, $widOpts, $relatedObj->getRatingsFromRelDataObj() );
				echo $args [ 'after_widget' ];
			} else {
				// else diplay empty widget
				$this->displayEmptyWidget( $args, $instance );
			}
		}
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' ended' );
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
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 */
	public function form( $instance ) {
		// Fill missing options
		if ( empty( $instance ) ) {
			$instance = erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;
		} else {
			$instance = $instance + erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;
		}

		// Pass it to viewData
		erpPROPaths::requireOnce( erpPROPaths::$erpPROView );
		$widgetInstance = $this;
		$optionsTemplate = EPR_PRO_BASE_PATH . 'admin/views/widgetSettings.php';
		erpPROView::render( $optionsTemplate, array (
				'options' => $instance,
				'widgetInstance' => $widgetInstance
		), true );
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
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 */
	public function update( $new_instance, $old_instance ) {
		/* #? Verify nonce */
		if ( !isset( $_POST [ 'erpPRO_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST [ 'erpPRO_meta_box_nonce' ], 'erpPRO_meta_box_nonce' ) ) {
			return;
		}
		erpPROPaths::requireOnce( erpPROPaths::$erpPROWidOpts );
		erpPROPaths::requireOnce( erpPROPaths::$erpPROWidTemplates );

		// get an instance to validate options
		$widOpts = new erpPROWidOpts( $old_instance );
		// validate wid options
		$widOptsValidated = $widOpts->saveOptions( $new_instance, $old_instance );
		// validate template options
		$template = new erpPROWidTemplates();
		$template->load( $new_instance [ 'dsplLayout' ] );

		if ( $template->isLoaded() ) {
			$tempalteOptionsValidated = $template->saveTemplateOptions( $new_instance );
		} else {
			$tempalteOptionsValidated = array ();
		}
		// save updated options
		return array_merge( $widOptsValidated, $tempalteOptionsValidated );
	}

	/**
	 * Just echoes an empty widget.
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @since 1.0.0
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 */
	private function displayEmptyWidget( $args, $instance ) {
		if ( !$instance [ 'hideIfNoPosts' ] ) {
			echo $args [ 'before_widget' ];
			echo $args [ 'before_title' ] . $instance [ 'title' ] . $args [ 'after_title' ];
			echo 'No related posts found';
			echo $args [ 'after_widget' ];
		}
	}
}