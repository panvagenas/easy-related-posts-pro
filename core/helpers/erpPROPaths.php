<?php

namespace helpers;

/**
 *
 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
 */
class erpPROPaths {
	// Helpers
	public static final $erpPRODBHelper = '/core/helpers/erpPRODBHelper.php';
	public static final $erpPROHTMLHelper = '/core/helpers/erpPROHTMLHelper.php';
	public static final $erpPROFileHelper = '/core/helpers/erpPROFileHelper.php';
	// Display
	public static final $erpPROPostData = '/core/display/erpPROPostData.php';
	public static final $erpPROView = '/core/display/erpPROView.php';
	// Admin
	public static final $easyRelatedPostsPROAdmin = '/core/helpers/easyRelatedPostsPROAdmin.php';
	// Cache
	public static final $erpPRODBActions = '/core/helpers/erpPRODBActions.php';
	// Includes
	public static final $resize = '/includes/resize.php';



	public static function requireOnce($path) {
		require_once EPR_PRO_BASE_PATH . $path;
	}
}