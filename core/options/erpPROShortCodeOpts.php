<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Options
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROOptions);
/**
 * Shortcode options class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
class erpPROShortCodeOpts extends erpPROOptions {
	public static $shortCodeProfilesArrayName = 'erpPROShortCodeProfiles';

	/**
	 * Profiles array as stored in DB
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $profiles;

	private $profileName;

	public function __construct( ) {
		parent::__construct();
		$this->optionsArrayName = erpPROShortCodeOpts::$shortCodeProfilesArrayName;
		$profiles = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);
		$this->profiles = is_array($profiles) ? $profiles : array();
		$this->defaults = erpPRODefaults::$shortCodeOpts+erpPRODefaults::$comOpts;
	}

	public function loadOptions( $profileName ) {
		$this->options = isset($this->profiles[$profileName]) ? $this->profiles[$profileName] : erpPRODefaults::$comOpts+erpPRODefaults::$shortCodeOpts;
		$this->profileName = $profileName;
		return $this;
	}

	public function isProfileLoaded() {
		return isset($this->profileName) && !empty($this->options);
	}

	/**
	 * Validates shortcode options
	 *
	 * @param array $options New options
	 * @return array Assoc array containg only the validated options
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function validateShortcodeOptions( Array $options ) {
		return $this->switchValidationTypes($options, erpPRODefaults::$shortcodeOptsValidations);
	}

	public function saveOptions( $newOptions ) {
	    // Validate template options
	    erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);
	    $template = new erpPROShortcodeTemplates();
	    $template->load($newOptions['dsplLayout']);
	    $templateOptions = $template->saveTemplateOptions($newOptions);
	    
	    $this->options = $templateOptions + $this->validateCommonOptions($newOptions) + $this->validateShortcodeOptions($newOptions);

	    if (isset($this->profileName)) {
		    $this->profiles[$this->profileName] = array_merge(erpPRODefaults::$comOpts+erpPRODefaults::$shortCodeOpts, $this->options);
		    return update_option(self::$shortCodeProfilesArrayName, $this->profiles);
	    } else {
		    return array_merge(erpPRODefaults::$comOpts+erpPRODefaults::$shortCodeOpts, $this->options);
	    }
	}

	public function getTemplateOptions($templateName, $newOptions) {
		erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);
		$template = new erpPROShortcodeTemplates();
		$template->load($templateName);

		if ($template->isLoaded()) {
			return $template->saveTemplateOptions($newOptions);
		} else {
			return array();
		}
	}

	/************************************************************************
	 * Geters for options
	 ************************************************************************/

	public function getSuppressOthers() {
		return isset($this->options['suppressOthers']) ? $this->options['suppressOthers'] : erpPRODefaults::$shortCodeOpts['suppressOthers'];
	}

	public function getPostTitleColor() {
		return $this->getValue('postTitleColor');
	}

	public function getExcColor() {
		return $this->getValue('excColor');
	}

	public function getPostTitleColorUse() {
		return $this->getValue('postTitleColorUse');
	}

	public function getExcColorUse() {
		return $this->getValue('excColorUse');
	}

	public function getHideIfNoPosts() {
		return $this->getValue('hideIfNoPosts');
	}

	public function getTaxExclude() {
		return $this->getValue('taxExclude');
	}

	public function getPtypeExclude() {
		return $this->getValue('ptypeExclude');
	}
}