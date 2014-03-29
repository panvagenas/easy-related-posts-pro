<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Shortcode handler class.
 *
 * @package Easy_Related_Posts
 * @author Your Name <email@example.com>
 */
 class erpPROShortcode {
 	/**
 	 * Shortcode options object
 	 *
 	 * @since 1.0.0
 	 * @var erpPROShortCodeOpts
 	 */
	private $optObj;
	/**
	 * @deprecated
	 *
	 * @since
	 * @var unknown
	 */
	private $scOpts;

	/**
	 * Profile name
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $profile;

	public function __construct($shortCodeProfile) {
		$this->profile = (string)$shortCodeProfile;
	}

	public function display($pid) {
		// TODO Remove debug
		do_action( 'debug', 'ShortCode started' );
		// TODO Remove debug
		do_action( 'debug', 'ShortCode translating options' );
		if (!isset($this->optObj)) {
			if(!$this->loadProfileOptions()){
				return '';
			}
		}

		erpPROPaths::requireOnce(erpPROPaths::$erpPROTemplates);
		if (!is_int($pid) || erpPROTemplates::areOthersSuppressed()) {
			$this->setSuppressOthers();
			return '';
		}

		erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);
		erpPROPaths::requireOnce(erpPROPaths::$erpProRelated);

		$relatedObj = erpProRelated::get_instance( $this->optObj->getOptions() );

		// TODO Remove debug
		do_action( 'debug', 'ShortCode geting related posts' );
		$result = $relatedObj->getRelated( $pid );
		// TODO Remove debug
		do_action( 'debug', 'ShortCode found '.$result->found_posts );
		$ratings = $relatedObj->getRatingsFromRelDataObj();

		if ( empty( $result ) || empty( $result->posts ) ) {
			return '';
		}

		$template = new erpPROShortcodeTemplates();
		$template->load($this->optObj->getValue('dsplLayout'));

		if (!$template->isLoaded()) {
			// TODO Remove debug
			do_action( 'debug', 'ShortCode unsuccessfull related, returning empty string' );
			return '';
		}
		// TODO Remove debug
		do_action( 'debug', 'ShortCode starting template' );
		$relContent = $template->display( $result, $this->optObj, $ratings );

		$this->setSuppressOthers();

		// TODO Remove debug
		do_action( 'debug', 'ShortCode returning rel content' );

		return $relContent;
	}

	/**
	 * Loads profile options from database and creates options object
	 * @return boolean true if profile was found, false otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function loadProfileOptions(){
		if (empty($this->profile)) {
			return false;
		}
		erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
		$profiles = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);

		if (empty($profiles) || empty($profiles[$this->profile])) {
			return false;
		}

		$erpOptions = erpPRODefaults::$comOpts+erpPRODefaults::$shortCodeOpts;

		$this->optObj = new erpPROShortCodeOpts();
		$this->optObj->setOptions(array_merge($erpOptions, $profiles[$this->profile]));
		return true;
	}

	/**
	 * @deprecated
	 * @return boolean
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since
	 */
	private function translateOptions() {
		// TODO Remove debug
		do_action( 'debug', 'ShortCode starting translating loop' );
		// Translating options
		if ( !empty($this->scOpts) ) {

			$erpOptions = erpPRODefaults::$comOpts+erpPRODefaults::$shortCodeOpts;
			$options = $this->scOpts;
			if (isset($this->scOpts['content'])) {
				$options['content'] = explode('-', $this->scOpts['content']);
				$excKeys = array_keys($options['content'], 'excerpt');
				if (!empty($excKeys)) {
					foreach ($excKeys as $key => $value) {
						unset($options['content'][$value]);
					}
				}
				unset($this->scOpts['content']);
			}

			foreach ($this->scOpts as $k => $v){
				foreach ($erpOptions as $key => $value){
					if ($k !== $key && $k === strtolower($key)) {
						$options[$key] = $v;
						unset($options[$k]);
						break;
					}
				}
			}

			erpPROPaths::requireOnce(erpPROPaths::$erpPROShortCodeOpts);
			$this->optObj = new erpPROShortCodeOpts();
			$this->optObj->setOptions(array_merge($erpOptions, $options));
			// TODO Remove debug
			do_action( 'debug', 'ShortCode options translated' );
			return true;
		}
		// TODO Remove debug
		do_action( 'debug', 'ShortCode empty attrs array, returning false' );
		return false;
	}

	private function setSuppressOthers() {
		// TODO Remove debug
		do_action( 'debug', 'ShortCode chck if have to suppress others' );
		// Setting supress others option
		erpPROPaths::requireOnce(erpPROPaths::$erpPROTemplates);
		if ( $this->optObj->getValue('suppress_other') === true ) {
			erpPROTemplates::suppressOthers(true);
		} elseif ( $this->optObj->getValue('suppress_other') === false) {
			erpPROTemplates::suppressOthers(false);
		}
	}
 }