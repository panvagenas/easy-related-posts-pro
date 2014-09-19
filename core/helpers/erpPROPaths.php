<?php

/**
 *
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROPaths {

    // Helpers
    public static $erpPRODBHelper = 'core/helpers/erpPRODBHelper.php';
    public static $erpPROHTMLHelper = 'core/helpers/erpPROHTMLHelper.php';
    public static $erpPROFileHelper = 'core/helpers/erpPROFileHelper.php';
	public static $WP_Admin_Notices = 'core/helpers/WP_Admin_Notices.php';
    // Display
    public static $erpPROPostData = 'core/display/erpPROPostData.php';
    public static $erpPROView = 'core/display/erpPROView.php';
    public static $erpPROTheme = 'core/display/erpPROTheme.php';
    public static $VPluginThemeFactory = 'core/display/VPluginThemeFactory.php';
    // Admin
    public static $easyRelatedPostsPROAdmin = 'admin/easyRelatedPostsPROAdmin.php';
    public static $erpPROActivator = 'admin/erpPROActivator.php';
    public static $erpPROWidget = 'admin/erpPROWidget.php';
    // Cache
    public static $erpPRODBActions = 'core/cache/erpPRODBActions.php';
    // Includes
    public static $bfiResizer = 'includes/bfi_thumb.php';
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
    public static $erpPROShortcode = 'front/erpPROShortcode.php';
    // Themes
    public static $mainThemesFolder = 'front/views/main';
    public static $widgetThemesFolder = 'front/views/widget';
    public static $scThemesFolder = 'front/views/shortcode';

    public static function requireOnce($path) {
        require_once EPR_PRO_BASE_PATH . $path;
    }
    
    public static function getAbsPath($path) {
        $fields = get_class_vars(__CLASS__);
        if(in_array($path, $fields)){
            return EPR_PRO_BASE_PATH . $path;
        } else {
            return new WP_Error('error', 'File '. EPR_PRO_BASE_PATH . $path.' is not found in class fields');
        }
    }

    public static function getClassFieldNames(){
        return array_keys((array)get_class_vars(__CLASS__));
    }

    public static function includeUpdater() {
        if (!class_exists('EDD_SL_Plugin_Updater')) {
            // load our custom updater if it doesn't already exist
            include( EPR_PRO_BASE_PATH . 'includes/EDD_SL_Plugin_Updater.php' );
        }
    }
}
