<?php
/**
 * Easy Related Posts PRO for WP
 *
 * @package   Easy related posts
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Related Posts PRO
 * Plugin URI:        @TODO
 * Description:       @TODO
 * Version:           1.0.0
 * Author:            Panagiotis Vagenas
 * Author URI:        @TODO
 * Text Domain:       easy-related-posts-eng
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI:
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/*----------------------------------------------------------------------------*
 * Global definitions
*----------------------------------------------------------------------------*/
if ( !defined( 'ERP_PRO_SLUG' ) ){
	define('ERP_PRO_SLUG', 'erp_pro');
}
if ( !defined( 'EPR_PRO_MAIN_OPTIONS_ARRAY_NAME' ) ){
	define('EPR_PRO_MAIN_OPTIONS_ARRAY_NAME', ERP_PRO_SLUG.'_main_options');
}
if ( !defined( 'EPR_PRO_BASE_PATH' ) ){
	define('EPR_PRO_BASE_PATH', plugin_dir_path(__FILE__));
}
if ( !defined( 'EPR_PRO_BASE_URL' ) ){
	define('EPR_PRO_BASE_URL', plugin_dir_url(__FILE__));
}
if ( !defined( 'ERP_PRO_RELATIVE_TABLE' ) ) {
	define( 'ERP_PRO_RELATIVE_TABLE', ERP_PRO_SLUG . '_related' );
}
if ( !class_exists( 'erpPRODefaults' ) ) {
	require_once EPR_PRO_BASE_PATH . 'core/options/defaults.php';
}
if ( !class_exists( 'erpPROPaths' ) ) {
	require_once EPR_PRO_BASE_PATH . 'core/helpers/erpPROPaths.php';
}

/*----------------------------------------------------------------------------*
 * Session functionality
*----------------------------------------------------------------------------*/
if ( !defined( 'WP_SESSION_COOKIE' ) )
	define( 'WP_SESSION_COOKIE', 'wp_erp_pro_session' );

if ( !class_exists( 'Recursive_ArrayAccess' ) ) {
	require_once ( plugin_dir_path( __FILE__ ) . 'core/session_manager/class-recursive-arrayaccess.php' );
}

// Only include the functionality if it's not pre-defined.
if ( !class_exists( 'WP_Session' ) ) {
	require_once ( plugin_dir_path( __FILE__ ) . 'core/session_manager/class-wp-session.php' );
	require_once ( plugin_dir_path( __FILE__ ) . 'core/session_manager/wp-session.php' );
}

/*----------------------------------------------------------------------------*
 * Core classes
*----------------------------------------------------------------------------*/


/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/
require_once( plugin_dir_path( __FILE__ ) . 'admin/widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/easyRelatedPostsPRO.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'easyRelatedPostsPRO', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'easyRelatedPostsPRO', 'deactivate' ) );

/**
 * Define cron job actions
 */
add_filter( 'cron_schedules', array('easyRelatedPostsPRO', 'addWeeklyCron') );
add_action( 'erpPRO_weekly_event_hook', array('easyRelatedPostsPRO','weeklyCronJob') );

add_action( 'plugins_loaded', array( 'easyRelatedPostsPRO', 'get_instance' ) );
add_action( 'widgets_init', function (){register_widget( "erpPROWidget" );} );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/**
 */
if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/easyRelatedPostsPROAdmin.php' );
	add_action( 'plugins_loaded', array( 'easyRelatedPostsPROAdmin', 'get_instance' ) );
}
