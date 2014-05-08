<?php

/**
 * Easy Related Posts PRO
 *
 * @package   Easy related posts
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Related Posts PRO
 * Plugin URI:        http://erp.xdark.eu
 * Description:       A powerfull plugin to display related posts
 * Version:           1.0.0
 * Author:            Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Author URI:        http://xdark.eu
 * Text Domain:       easy-related-posts-eng
 * Domain Path:       /languages
 * Codecanyon URI:    @TODO Codecanyon uri
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/* ----------------------------------------------------------------------------*
 * Global definitions
 * ---------------------------------------------------------------------------- */
if (!defined('ERP_PRO_SLUG')) {
    define('ERP_PRO_SLUG', 'erp_pro');
}
if (!defined('EPR_PRO_MAIN_OPTIONS_ARRAY_NAME')) {
    define('EPR_PRO_MAIN_OPTIONS_ARRAY_NAME', ERP_PRO_SLUG . '_main_options');
}
if (!defined('EPR_PRO_BASE_PATH')) {
    define('EPR_PRO_BASE_PATH', plugin_dir_path(__FILE__));
}
if (!defined('EPR_PRO_BASE_URL')) {
    define('EPR_PRO_BASE_URL', plugin_dir_url(__FILE__));
}
if (!defined('EPR_PRO_DEFAULT_THUMBNAIL')) {
    define('EPR_PRO_DEFAULT_THUMBNAIL', plugin_dir_url(__FILE__) . 'front/assets/img/noImage.png');
}
if (!defined('ERP_PRO_RELATIVE_TABLE')) {
    define('ERP_PRO_RELATIVE_TABLE', ERP_PRO_SLUG . '_related');
}

/* ----------------------------------------------------------------------------*
 * Session functionality
 * ---------------------------------------------------------------------------- */
if (!defined('WP_SESSION_COOKIE')) {
    define('WP_SESSION_COOKIE', 'wp_erp_pro_session');
}

if (!class_exists('Recursive_ArrayAccess')) {
    require_once ( plugin_dir_path(__FILE__) . 'core/session_manager/class-recursive-arrayaccess.php' );
}

// Only include the functionality if it's not pre-defined.
if (!class_exists('WP_Session')) {
    require_once ( plugin_dir_path(__FILE__) . 'core/session_manager/class-wp-session.php' );
    require_once ( plugin_dir_path(__FILE__) . 'core/session_manager/wp-session.php' );
}

/* ----------------------------------------------------------------------------*
 * Core classes
 * ---------------------------------------------------------------------------- */

if (!class_exists('erpPRODefaults')) {
    require_once EPR_PRO_BASE_PATH . 'core/options/erpPRODefaults.php';
}
if (!class_exists('erpPROPaths')) {
    require_once EPR_PRO_BASE_PATH . 'core/helpers/erpPROPaths.php';
}

/* ----------------------------------------------------------------------------*
 * Public-Facing Functionality
 * ---------------------------------------------------------------------------- */
erpPROPaths::requireOnce(erpPROPaths::$erpPROWidget);
erpPROPaths::requireOnce(erpPROPaths::$easyRelatedPostsPRO);

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook(__FILE__, array('easyRelatedPostsPRO', 'activate'));
register_deactivation_hook(__FILE__, array('easyRelatedPostsPRO', 'deactivate'));

/**
 * Define cron job actions
 */
add_filter('cron_schedules', array('easyRelatedPostsPRO', 'addWeeklyCron'));
add_action('erpPRO_weekly_event_hook', array('easyRelatedPostsPRO', 'weeklyCronJob'));
/**
 * Register plugin and widget
 */
add_action('plugins_loaded', array('easyRelatedPostsPRO', 'get_instance'));
add_action('widgets_init', function () {
    register_widget("erpPROWidget");
});
/**
 * Shortcode functionality
 */

/**
 * Shortcode function
 *
 * @param array $attrs
 * @return string
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since 1.0.0
 */
function erpPROShortcode($attrs) {

    // If no profile is set return empty string
    if (!isset($attrs['profile'])) {
        return '';
    }

    global $post;
    if($post == null){
        return '';
    }
    erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcode);

    $sc = new erpPROShortcode($attrs['profile']);
    return $sc->display($post->ID);
}

add_shortcode('erp', 'erpPROShortcode');

/* ----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 * ---------------------------------------------------------------------------- */
/**
 */
if (is_admin()) {
    erpPROPaths::requireOnce(erpPROPaths::$easyRelatedPostsPROAdmin);
    add_action('plugins_loaded', array('easyRelatedPostsPROAdmin', 'get_instance'));
}
