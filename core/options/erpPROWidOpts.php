<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Options
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license   // TODO Licence
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROOptions);
/**
 * Widget options class.
 *
 * @package Easy_Related_Posts_Options
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROWidOpts extends erpPROOptions {

	public function __construct( Array $instance = NULL ) {
		$this->optionsArrayName = 'widget_' . erpPRODefaults::erpPROWidgetOptionsArrayName;

		if ( $instance !== NULL && !empty( $instance ) ) {
			$this->options = $instance;
		}

		$this->defaults = erpPRODefaults::$widOpts+erpPRODefaults::$comOpts;
	}

	/**
	 * Validates widget options
	 *
	 * @param array $options New options
	 * @return array Assoc array containg only the validated options
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function validateWidgetOptions( Array $options ) {
		return $this->switchValidationTypes($options, erpPRODefaults::$widOptsValidations);
	}

	public function saveOptions( $new_instance, $old_instance ) {
		return $this->validateCommonOptions($new_instance)+$this->validateWidgetOptions($new_instance);
	}

	/************************************************************************
	 * Geters for options
	************************************************************************/

	public function getPostTitleColor() {
		return $this->getValue('postTitleColor');
	}

	public function getExcColor() {
		return $this->getValue('excColor');
	}

	public function getHideIfNoPosts() {
		return $this->getValue('hideIfNoPosts');
	}
}