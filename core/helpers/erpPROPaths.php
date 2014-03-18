<?php

/**
 *
 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
 */
class erpPROPaths {
	// Helpers
	public static $erpPRODBHelper = 'core/helpers/erpPRODBHelper.php';
	public static $erpPROHTMLHelper = 'core/helpers/erpPROHTMLHelper.php';
	public static $erpPROFileHelper = 'core/helpers/erpPROFileHelper.php';
	// Display
	public static $erpPROPostData = 'core/display/erpPROPostData.php';
	public static $erpPROView = 'core/display/erpPROView.php';
	public static $erpPROMainTemplates = 'core/display/erpPROMainTemplates.php';
	public static $erpPROShortcodeTemplates = 'core/display/erpPROShortcodeTemplates.php';
	public static $erpPROTemplates = 'core/display/erpPROTemplates.php';
	public static $erpPROWidTemplates = 'core/display/erpPROWidTemplates.php';
	// Admin
	public static $easyRelatedPostsPROAdmin = 'admin/easyRelatedPostsPROAdmin.php';
	public static $erpPROActivator = 'admin/erpPROActivator.php';
	public static $erpPROWidget = 'admin/erpPROWidget.php';
	// Cache
	public static $erpPRODBActions = 'core/cache/erpPRODBActions.php';
	// Includes
	public static $resize = 'includes/resize.php';
	// Options
	public static $erpPROWidOpts = 'core/options/erpPROWidOpts.php';
	public static $erpPROShortCodeOpts = 'core/options/erpPROShortCodeOpts.php';
	public static $erpPROOptions = 'core/options/erpPROOptions.php';
	public static $erpPROMainOpts = 'core/options/erpPROMainOpts.php';
	public static $erpPRODefaults = 'core/options/erpPRODefaults.php';
	// Related
	public static $erpPROQueryFormater = 'core/related/erpPROQueryFormater.php';
	public static $erpProRelated = 'core/related/erpProRelated.php';
	public static $erpPRORelData = 'core/related/erpPRORelData.php';
	public static $erpPRORatingSystem = 'core/related/erpPRORatingSystem.php';
	// Front
	public static $easyRelatedPostsPRO = 'front/easyRelatedPostsPRO.php';
	public static $erpPROTracker = 'front/erpPROTracker.php';



	public static function requireOnce($path) {
		require_once EPR_PRO_BASE_PATH . $path;
	}
}