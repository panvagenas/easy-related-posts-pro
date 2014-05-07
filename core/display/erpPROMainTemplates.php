<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Core_display
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROTemplates);
/**
 * Main plugin templates class
 *
 * @package Easy_Related_Posts_Core_display
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROMainTemplates extends erpPROTemplates {
	/**
	 */
	function __construct( ) {
		parent::__construct();
		$this->templatesBasePath = parent::getTemplatesBasePath() . '/main';
	}

	/**
	 */
	function __destruct( ) {
		parent::__destruct();
	}
	/**
	 * (non-PHPdoc)
	 * @see \display\erpPROTemplates::display()
	 * @since 1.0.0
	 */
	public function display(WP_Query $wpq, erpPROOptions $optObj, $ratings = array()) {
		// Check if we should return empty content
		if (parent::areOthersSuppressed() === true) {
			return '';
		}
		// Return content
		return parent::display($wpq, $optObj, $ratings);
	}
	
	public function deleteTemplateOptions() {
	    if(!$this->isLoaded() || !isset($this->optionsArrayName)){
		return FALSE;
	    }
	    return delete_option($this->optionsArrayName);
	}
}

?>