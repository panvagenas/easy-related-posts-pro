<?php
erpPROPaths::requireOnce(erpPROPaths::$erpPROTemplates);
/**
 *
 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
 */
class erpPROShortcodeTemplates extends erpPROTemplates {

	/**
	 */
	function __construct( ) {
		parent::__construct();
		$this->templatesBasePath = parent::getTemplatesBasePath() . '/shortcode';
	}

	/**
	/* Overides parent to prevent sc options to be saved in db
	 * @see erpPROTemplates::areOthersSuppressed()
	 * @since 1.0.0
	 */
	public function saveTemplateOptions($newOptions) {
		if (empty($newOptions) ) {
			return array();
		}
		$this->setOptions(apply_filters('erpPROTemplateOptionsSaveValidation', $newOptions));
		return is_array($this->options) ? $this->options : array();
	}

	/**
	 * (non-PHPdoc)
	 * @see erpPROTemplates::display()
	 * @since 1.0.0
	 */
	public function display(WP_Query $wpq, erpPROOptions $optObj, $ratings = array()) {
		// Check if we should return empty content
		if (parent::areOthersSuppressed() === true) {
			// TODO Remove debug
			do_action( 'debug', 'erpPROShortcodeTemplates suppressed' );
			return '';
		}
		// Return content
		return parent::display($wpq, $optObj, $ratings);
	}

	/**
	 */
	function __destruct( ) {

		// TODO - Insert your code here
	}
}

?>