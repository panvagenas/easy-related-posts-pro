<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Core_display
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROTemplates);
/**
 * Main plugin templates class
 *
 * @package Easy_Related_Posts_Core_display
 * @author Your Name <email@example.com>
 */
class erpPROMainTemplates extends erpPROTemplates {
	public static $supressOthers = false;

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
	public function display(WP_Query $wpq, erpPROOptions $optObj, $ratings = array(), $supressOthers = FALSE) {
		// Check if we should return empty content
		if (self::$supressOthers === true) {
			return '';
		}
		// Check if we should suppress others
		if ($supressOthers) {
			self::$supressOthers = true;
		}
		// Return content
		return parent::display($wpq, $optObj, $ratings);
	}
}

?>