<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Easy related posts
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license   // TODO Licence
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . 'easy-related-posts-pro.php';

class erpUninstall {

    /**
     * Fired when the plugin is deactivated.
     *
     * @since 1.0.0
     */
    public static function uninstall() {
	if (function_exists('is_multisite') && is_multisite()) {
	    // Get all blog ids
	    $blog_ids = self::get_blog_ids();

	    foreach ($blog_ids as $blog_id) {

		switch_to_blog($blog_id);
		self::single_uninstall();
	    }

	    restore_current_blog();
	} else {
	    self::single_uninstall();
	}
    }

    /**
     * Get all blog ids of blogs in the current network that are:
     * - not archived
     * - not spam
     * - not deleted
     *
     * @since 1.0.0
     * @return array false blog ids, false if no matches.
     */
    private static function get_blog_ids() {
	global $wpdb;

	// get an array of blog ids
	$sql = "SELECT blog_id FROM $wpdb->blogs
		WHERE archived = '0' AND spam = '0'
		AND deleted = '0'";

	return $wpdb->get_col($sql);
    }

    /**
     * Fired for each blog when the plugin is deactivated.
     *
     * @since 1.0.0
     */
    private static function single_uninstall() {
	/**
	 * Delete rel table
	 */
	self::delRelTable();
	
	/**
	 * Del main options
	 */
	self::delMainOptions();
	
	/**
	 * Del templates options
	 */
	self::delTemplateOptions();
	
	/**
	 * Del wid options
	 */
	self::delWidOptions();
	
	/**
	 * Del shortcode profiles
	 */
	self::delShortCodeProfiles();
        
        /**
         * Del version numbers
         */
        self::deleteVersionNumbers();
    }
    
    private static function delRelTable() {
	global $wpdb;
	$optionsTableName  = $wpdb->prefix . ERP_PRO_RELATIVE_TABLE;
	require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$sql = "DROP TABLE IF EXISTS " . $optionsTableName . ";";
	dbDelta( $sql );
    }
    
    private static function delMainOptions() {
	erpPROPaths::requireOnce(erpPROPaths::$erpPROMainOpts);
	$mOpts = new erpPROMainOpts();
	delete_option($mOpts->getOptionsArrayName());
    }
    
    private static function delTemplateOptions() {
	erpPROPaths::requireOnce(erpPROPaths::$erpPROMainTemplates);
	$mTemps = new erpPROMainTemplates();
	foreach ($mTemps->getTemplateNames() as $key => $value) {
	    $mTemps->load($value);
	    $mTemps->deleteTemplateOptions();
	}
    }
    
    private static function delWidOptions() {
	erpPROPaths::requireOnce(erpPROPaths::$erpPROWidOpts);
	$wOpts = new erpPROWidOpts();
	delete_option($wOpts->getOptionsArrayName());
    }
    
    private static function delShortCodeProfiles() {
	erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
	delete_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);
    }
    
    private static function deleteVersionNumbers() {
        delete_option(erpPRODefaults::versionNumOptName);
    }
}

erpUninstall::uninstall();