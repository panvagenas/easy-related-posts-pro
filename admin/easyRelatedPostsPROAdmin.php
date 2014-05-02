<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Admin
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license   // TODO Licence
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

/**
 * Plugin class.
 * This class should ideally be used to work with the
 * administrative side of the WordPress site.
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name.php`
 *
 * @package Easy_Related_Posts_Admin
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class easyRelatedPostsPROAdmin {

    /**
     * Instance of this class.
     *
     * @since 1.0.0
     * @var easyRelatedPostsPROAdmin
     */
    protected static $instance = null;

    /**
     * Slug of the plugin screen.
     *
     * @since 1.0.0
     * @var string
     */
    protected $plugin_screen_hook_suffix = null;

    /**
     * The name of the array that holds SC profiles
     *
     * @since 1.0.0
     * @var string
     */
    private $shortCodeProfilesArrayName = 'erpPROShortCodeProfiles';

    /**
     *
     * @var string 
     */
    private $plugin_slug;

    /**
     * Initialize the plugin by loading admin scripts & styles and adding a
     * settings page and menu.
     *
     * @since 1.0.0
     */
    private function __construct() {

	/**
	 * *****************************************************
	 * admin class should only be available for super admins
	 * *****************************************************
	 */
	if (!is_super_admin()) {
	    return;
	}

	/**
	 * ******************************************************
	 * Call $plugin_slug from public plugin class.
	 * *****************************************************
	 */
	$plugin = easyRelatedPostsPRO::get_instance();
	$this->plugin_slug = $plugin->get_plugin_slug();

	// Load admin style sheet and JavaScript.
	add_action('admin_enqueue_scripts', array(
	    $this,
	    'enqueue_admin_styles'
	));
	add_action('admin_enqueue_scripts', array(
	    $this,
	    'enqueue_admin_scripts'
	));

	/**
	 * ******************************************************
	 * Add the options page and menu item.
	 * *****************************************************
	 */
	add_action('admin_menu', array(
	    $this,
	    'add_plugin_admin_menu'
	));

	/**
	 * ******************************************************
	 * Add an action link pointing to the options page.
	 * *****************************************************
	 */
	$plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->plugin_slug . '.php');
	add_filter('plugin_action_links_' . $plugin_basename, array(
	    $this,
	    'add_action_links'
	));

	/**
	 * ******************************************************
	 * Save options
	 * *****************************************************
	 */
	add_action('admin_post_save_' . EPR_PRO_MAIN_OPTIONS_ARRAY_NAME, array(
	    $this,
	    'saveOptions'
	));

	// Do rating when saving posts
	add_action('transition_post_status', array(
	    $this,
	    'doRating'
		), 10, 3);

	/**
	 * ******************************************************
	 * Delete cache entries when a post is deleted
	 * *****************************************************
	 */
	add_action('delete_post', array(
	    $this,
	    'deletePostInCache'
		), 10);

	/**
	 * ******************************************************
	 * Ajax hooks
	 * *****************************************************
	 */
	add_action('wp_ajax_loadTemplateOptions', array(
	    $this,
	    'loadTemplateOptions'
	));

	add_action('wp_ajax_erpClearCache', array(
	    $this,
	    'clearCache'
	));

	add_action('wp_ajax_erpRebuildCache', array(
	    $this,
	    'rebuildCache'
	));

	add_action('wp_ajax_loadSCTemplateOptions', array(
	    $this,
	    'loadSCTemplateOptions'
	));
	add_action('wp_ajax_erploadShortcodeProfile', array(
	    $this,
	    'loadShortcodeProfile'
	));
	add_action('wp_ajax_erpsaveShortcodeProfile', array(
	    $this,
	    'saveShortcodeProfile'
	));

	add_action('wp_ajax_erpdeleteShortCodeProfile', array(
	    $this,
	    'deleteShortCodeProfile'
	));

	add_action('wp_ajax_erpgetShortCodeProfiles', array(
	    $this,
	    'getShortCodeProfiles'
	));

	add_action('wp_ajax_erpgetShortCodeHelperContent', array(
	    $this,
	    'getShortCodeHelperContent'
	));

	/**
	 * MCE Helper
	 */

	/**
	 * ******************************************
	 * TODO Remove this before release
	 */
	function my_refresh_mce($ver) {
	    $ver += 13;
	    return $ver;
	}

	// init process for button control
	add_filter('tiny_mce_version', 'my_refresh_mce');
	/**
	 * TODO Remove this before release
	 * *****************************************
	 */
	add_action('init', array(
	    $this,
	    'erpPROButtonHook'
	));
    }

    /**
     * Return an instance of this class.
     *
     * @since 1.0.0
     * @return object A single instance of this class.
     */
    public static function get_instance() {

	/*
	 * admin class should only be available for super admins
	 */
	if (!is_super_admin()) {
	    return;
	}

	// If the single instance hasn't been set, set it now.
	if (null == self::$instance) {
	    self::$instance = new self();
	}

	return self::$instance;
    }

    public function doRating($newStatus, $oldStatus, $post) {
	// If a revision get the pid from parent
	$revision = wp_is_post_revision($post->ID);
	if ($revision) {
	    $pid = $revision;
	} else {
	    $pid = $post->ID;
	}

	if ($oldStatus == 'publish' && $newStatus != 'publish') {
	    // Post is now unpublished, we should remove cache entries
	    $this->deletePostInCache($pid);
	} elseif ($newStatus == 'publish') {
            $plugin = easyRelatedPostsPRO::get_instance();
            
            if($plugin->isInExcludedPostTypes($pid) || $plugin->isInExcludedTaxonomies($pid)){
                return;
            }
	    erpPROPaths::requireOnce(erpPROPaths::$erpProRelated);
	    erpPROPaths::requireOnce(erpPROPaths::$erpPROMainOpts);

	    $opts = new erpPROMainOpts();

	    $opts->setOptions(array(
		'queryLimit' => 1000
	    ));
	    $rel = erpProRelated::get_instance($opts);

	    $rel->doRating($pid);
	}
    }

    /**
     * Register and enqueue admin-specific style sheet.
     *
     * @since 1.0.0
     * @return null Return early if no settings page is registered.
     */
    public function enqueue_admin_styles() {
	if (!isset($this->plugin_screen_hook_suffix)) {
	    return;
	}

	$screen = get_current_screen();
	if ($this->plugin_screen_hook_suffix == $screen->id || 'widgets' == $screen->id) {
	    wp_enqueue_style('wp-color-picker');
	    wp_enqueue_style($this->plugin_slug . '-admin-styles', plugins_url('assets/css/admin.css', __FILE__), array(), easyRelatedPostsPRO::VERSION);
	}
	if ($screen->id === 'post') {
	    wp_enqueue_style($this->plugin_slug . '-admin-styles', plugins_url('assets/css/admin.css', __FILE__), array(), easyRelatedPostsPRO::VERSION);
	    wp_enqueue_style($this->plugin_slug . '-SCHelper-styles', plugins_url('assets/css/SCHelper.css', __FILE__), array(), easyRelatedPostsPRO::VERSION);
	}
    }

    /**
     * Register and enqueue admin-specific JavaScript.
     *
     * @since 1.0.0
     * @return null Return early if no settings page is registered.
     */
    public function enqueue_admin_scripts() {
	if (!isset($this->plugin_screen_hook_suffix)) {
	    return;
	}

	$screen = get_current_screen();

	if ($this->plugin_screen_hook_suffix == $screen->id || 'widgets' == $screen->id) {
	    wp_enqueue_script('jquery');
	    wp_enqueue_script('jquery-ui-core');
	    wp_enqueue_script('wp-color-picker');
	    wp_enqueue_script('jquery-effects-fade');
	    wp_enqueue_script('jquery-ui-tabs');
	    wp_enqueue_script('jquery-ui-tooltip');
	    wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_script('jquery-ui-slider');

	    wp_enqueue_script($this->plugin_slug . '-admin-script', plugins_url('assets/js/admin.js', __FILE__), array(
		'jquery',
		'jquery-ui-tabs'
		    // $this->plugin_slug . '-qtip'
		    ), easyRelatedPostsPRO::VERSION);
	}
	if ($this->plugin_screen_hook_suffix == $screen->id) {
	    wp_enqueue_script($this->plugin_slug . '-main-settings', plugins_url('assets/js/mainSettings.js', __FILE__), array(
		$this->plugin_slug . '-admin-script'
		    ), easyRelatedPostsPRO::VERSION);
	}
	if ('widgets' == $screen->id) {
	    wp_enqueue_script($this->plugin_slug . '-widget-settings', plugins_url('assets/js/widgetSettings.js', __FILE__), array(
		$this->plugin_slug . '-admin-script'
		    ), easyRelatedPostsPRO::VERSION);
	}
	if ($screen->id === 'post') {
	    wp_enqueue_script('jquery');
	    wp_enqueue_script('jquery-ui-core');
	    wp_enqueue_script('jquery-ui-tabs');
	    wp_enqueue_script('jquery-ui-dialog');
	    wp_enqueue_script('jquery-ui-tooltip');
	    wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_script('jquery-ui-slider');

	    wp_enqueue_script($this->plugin_slug . '-jq-form', plugins_url('assets/js/jq.form.min.js', __FILE__), array(
		'jquery'
		    ), easyRelatedPostsPRO::VERSION);
	}
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since 1.0.0
     */
    public function add_plugin_admin_menu() {
	$this->plugin_screen_hook_suffix = add_options_page(__('Easy Related Posts PRO Settings', $this->plugin_slug), __('Easy Related Posts PRO Settings', $this->plugin_slug), 'manage_options', $this->plugin_slug . '_settings', array(
	    $this,
	    'display_plugin_admin_page'
		));
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since 1.0.0
     */
    public function display_plugin_admin_page() {
	if (!class_exists('erpPROView')) {
	    erpPROPaths::requireOnce(erpPROPaths::$erpPROView);
	}
	$defaultOptions = erpPRODefaults::$mainOpts + erpPRODefaults::$comOpts;
	$optObj = new erpPROMainOpts();
	$options = $optObj->getOptions();

	$viewData ['erpPROOptions'] = is_array($options) ? array_merge($defaultOptions, $options) : $defaultOptions;
	$viewData ['optObj'] = $optObj;

	erpPROView::render(plugin_dir_path(__FILE__) . 'views/admin.php', $viewData, TRUE);
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since 1.0.0
     */
    public function add_action_links($links) {
	return array_merge(array(
	    'settings' => '<a href="' . admin_url('options-general.php?page=' . $this->plugin_slug) . '">' . __('Settings', $this->plugin_slug) . '</a>'
		), $links);
    }

    /**
     * Saves admin options.
     * This is called through a hook
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function saveOptions() {
	if (!current_user_can('manage_options')) {
	    wp_die('Not allowed');
	}
	erpPROPaths::requireOnce(erpPROPaths::$erpPROMainOpts);
	erpPROPaths::requireOnce(erpPROPaths::$erpPROMainTemplates);
	// Save template options
	if (isset($_POST ['dsplLayout'])) {
	    $templateObj = new erpPROMainTemplates();
	    $templateObj->load($_POST ['dsplLayout']);
	    if ($templateObj->isLoaded()) {
		$templateObj->saveTemplateOptions($_POST);
		$templateOptions = $templateObj->getOptions();
		foreach ($templateOptions as $key => $value) {
		    unset($_POST [$key]);
		}
	    }
	}
	// Save the rest of the options
	$mainOptionsObj = new erpPROMainOpts();
	$mainOptionsObj->saveOptions($_POST);
	wp_redirect(add_query_arg(array(
	    'page' => $this->plugin_slug . '_settings',
	    'tab-spec' => wp_strip_all_tags($_POST ['tab-spec'])
			), admin_url('options-general.php')));
	exit();
    }

    /**
     * Clears cache.
     * !IMPORTAND! Not to be called directly. Only through ajax
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function clearCache() {
	if (!user_can_access_admin_page() || !current_user_can('manage_options')) {
	    echo json_encode(false);
	    die();
	}
	erpPROPaths::requireOnce(erpPROPaths::$erpPRODBActions);
	$db = erpPRODBActions::getInstance();
	$db->emptyRelTable();
	echo json_encode(true);
	die();
    }

    public function deletePostInCache($pid) {
	erpPROPaths::requireOnce(erpPROPaths::$erpPRODBActions);
	$db = erpPRODBActions::getInstance();
	$db->deleteAllOccurrences($pid);
    }

    /**
     * This is for a future release.
     * It should be called through ajax and rebuild cache for all posts in that are cached
     * 
     * FIXME This functionality will not be used until we find a way to make sure mem limit not reached
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function rebuildCache() {
	if (!user_can_access_admin_page() || !current_user_can('manage_options')) {
	    echo json_encode(false);
	    die();
	}
	// This may take a while so set time limit to 0
	set_time_limit(0);

	erpPROPaths::requireOnce(erpPROPaths::$erpPRODBActions);
	erpPROPaths::requireOnce(erpPROPaths::$erpPROMainOpts);
	erpPROPaths::requireOnce(erpPROPaths::$erpProRelated);

	$db = erpPRODBActions::getInstance();
	$mainOpts = new erpPROMainOpts();
	$rel = erpProRelated::get_instance($mainOpts);

	$allCached = $db->getUniqueIds();
	$db->emptyRelTable();
        
        $plugin = easyRelatedPostsPRO::get_instance();
        global $wpdb, $wp_actions;
	foreach ($allCached as $key => $value) {
            $pid = (int) $value ['pid'];
            
            if($plugin->isInExcludedPostTypes($pid) || $plugin->isInExcludedTaxonomies($pid)){
                continue;
            }
            $rel->doRating($pid);
	}

	echo json_encode(true);
	die();
    }

    /**
     * Echoes json string of the profile define in $_POST [ 'profileName' ].
     * If profile not found in DB then echoes false
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function loadShortcodeProfile() {
	if (!current_user_can('edit_posts')) {
	    echo json_encode(array(
		'error' => 'Action not allowed'
	    ));
	    die();
	}
	if (!isset($_POST ['profileName'])) {
	    echo json_encode(array(
		'error' => 'You must set a profile name'
	    ));
	    die();
	}
	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
	$profile = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);

	if (!$profile || !isset($profile [$_POST ['profileName']]) || !is_array($profile [$_POST ['profileName']])) {
	    echo json_encode(array(
		'error' => 'Profile not found in database'
	    ));
	    die();
	}

	echo json_encode($profile [$_POST ['profileName']]);
	die();
    }

    /**
     * Saves shortcode profile in DB
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function saveShortcodeProfile() {
	if (!current_user_can('edit_posts')) {
	    echo json_encode(array(
		'error' => 'Action not allowed'
	    ));
	    die();
	}
	if (!isset($_POST ['profileName']) || empty($_POST ['profileName'])) {
	    echo json_encode(array(
		'error' => 'You must set a profile name and define all options'
	    ));
	    die();
	}

	$profileName = wp_strip_all_tags($_POST ['profileName']);
	unset($_POST ['profileName']);
	$profileOptions = $_POST;

	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);

	$scOpts = new erpPROShortCodeOpts();

	$scOpts->loadOptions($profileName);

	$res = $scOpts->saveOptions($profileOptions);

	echo json_encode(array(
	    'result' => $res,
	    'profileName' => $profileName
	));
	die();
    }

    /**
     * Deletes a SC profile if is present in DB
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function deleteShortCodeProfile() {
	if (!current_user_can('edit_posts')) {
	    echo json_encode(array(
		'error' => 'Action not allowed'
	    ));
	    die();
	}
	if (!isset($_POST ['profileName']) || empty($_POST ['profileName'])) {
	    echo json_encode(array(
		'error' => 'You must select a profile'
	    ));
	    die();
	}

	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
	$profile = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);
	$profileName = wp_strip_all_tags($_POST ['profileName']);

	if (!$profile || !isset($profile [$profileName]) || !is_array($profile [$profileName])) {
	    echo json_encode(array(
		'error' => 'Profile not found in database'
	    ));
	    die();
	} else {
	    unset($profile [$profileName]);
	    echo json_encode(update_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName, $profile));
	    die();
	}
    }

    /**
     * Echoes json string with all SC profiles found in DB
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getShortCodeProfiles() {
	if (!current_user_can('edit_posts')) {
	    echo json_encode(array(
		'error' => 'Action not allowed'
	    ));
	    die();
	}

	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
	$profile = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);

	if (!is_array($profile)) {
	    $profile = array();
	}
	echo json_encode($profile);
	die();
    }

    /**
     * Echoes html to be desplayed in shortcode helper
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getShortCodeHelperContent() {
	if (!current_user_can('edit_posts')) {
	    echo json_encode(array(
		'error' => 'Action not allowed'
	    ));
	    die();
	}

	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);
	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
	
	$profilesOptionsArray = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);
	// If profile name is set get options
	if (isset($_GET ['profileName'])) {
	    $profileName = wp_strip_all_tags($_GET ['profileName']);
	    $profileOpts = isset($profilesOptionsArray [$profileName]) ? $profilesOptionsArray [$profileName] : null;
	} 
	// If no options are set get first profile in the array
	if (empty($profileOpts)) {
	    $profileName = array_shift(array_keys($profilesOptionsArray));
	    $profileOpts = $profileName === null ? null : $profilesOptionsArray[$profileName];
	}
	// Profile array is empty or profile not found, set to defaults
	if (empty($profileOpts)) {
	    $profileOpts = erpPRODefaults::$comOpts + erpPRODefaults::$shortCodeOpts;
	    $profileName = 'default';
	}

	$template = new erpPROShortcodeTemplates();
	$template->load($profileOpts ['dsplLayout']);

	if (!$template->isLoaded()) {
	    echo json_encode(array(
		'error' => 'Template is not defined'
	    ));
	    die();
	}

	erpPROPaths::requireOnce(erpPROPaths::$erpPROView);

	echo erpPROView::render(plugin_dir_path(__FILE__) . '/views/shortcodeHelper.php', array(
	    'profileName' => $profileName,
	    'erpPROOptions' => $profileOpts,
	    'shortCodeProfilesArrayName' => $this->shortCodeProfilesArrayName
	));
	die();
    }

    /**
     * This is called through ajax hook and returns the plugin options as defined in template settings file
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function loadTemplateOptions() {
	if (!isset($_POST ['template']) || !isset($_POST ['templateRoot'])) {
	    echo json_encode(false);
	    die();
	}
	erpPROPaths::requireOnce(erpPROPaths::$erpPROMainTemplates);

	$templateObj = new erpPROMainTemplates();
	$templateObj->load($_POST ['template']);

	$data = array(
	    'content' => $templateObj->renderSettings(false),
	    'optionValues' => $templateObj->getOptions()
	);

	echo json_encode($data);
	die();
    }

    /**
     * This is called through ajax hook and returns the plugin options as defined in template settings file
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function loadSCTemplateOptions() {
	if (!isset($_POST ['template'])) {
	    echo json_encode(false);
	    die();
	}
	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);

	if (isset($_POST ['profileName'])) {
	    $profileName = $_POST ['profileName'];
	    erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
	    $profilesOptionsArray = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);
	    $profileOpts = isset($profilesOptionsArray [$profileName]) ? $profilesOptionsArray [$profileName] : null;
	}

	if (empty($profileOpts)) {
	    $profileOpts = erpPRODefaults::$comOpts + erpPRODefaults::$shortCodeOpts;
	    $profileName = 'default';
	}

	$templateObj = new erpPROShortcodeTemplates();
	$templateObj->load($_POST ['template']);
	$templateObj->setOptions($profileOpts);

	$data = array(
	    'content' => $templateObj->renderSettings(false),
	    'optionValues' => $profilesOptionsArray
	);

	echo json_encode($data);
	die();
    }

    /**
     * Hooks shortcode helper to MCE editor
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    function erpPROButtonHook() {
	if (current_user_can('edit_posts') && get_user_option('rich_editing') == 'true') {
	    add_filter("mce_external_plugins", array(
		$this,
		"defineMCEHelperJS"
	    ));
	    add_filter('mce_buttons', array(
		$this,
		'registerMCEButton'
	    ));
	}
    }

    /**
     * Adds custom button to MCE editor
     *
     * @param array $buttons
     * @return array
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    function registerMCEButton($buttons) {
	$screen = get_current_screen();
	if (!isset($screen->id) || $screen->id !== 'post') {
	    return $buttons;
	}
	array_push($buttons, "|", "erpproshortcodehelper");
	return $buttons;
    }

    /**
     * Defines path to shortcode helper js file
     *
     * @param array $pluginArray
     * @return array
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    function defineMCEHelperJS($pluginArray) {
	$screen = get_current_screen();
	if (!isset($screen->id) || $screen->id !== 'post') {
	    return $pluginArray;
	}
	$pluginArray ['erpproshortcodehelper'] = plugins_url('/assets/js/erpPROMCEPlugin.js', __FILE__);
	return $pluginArray;
    }

}
