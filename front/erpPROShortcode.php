<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

/**
 * Shortcode handler class.
 *
 * @package Easy_Related_Posts
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
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

		erpPROPaths::requireOnce(erpPROPaths::$VPluginThemeFactory);
		erpPROPaths::requireOnce(erpPROPaths::$erpProRelated);

		$relatedObj = erpProRelated::get_instance( $this->optObj );

		$result = $relatedObj->getRelated( $pid );
		$ratings = $relatedObj->getRatingsFromRelDataObj();

		if ( empty( $result ) || empty( $result->posts ) ) {
			return '';
		}
                
                VPluginThemeFactory::registerThemeInPathRecursive(erpPROPaths::getAbsPath(erpPROPaths::$scThemesFolder), $this->optObj->getDsplLayout());
                $theme = VPluginThemeFactory::getThemeByName($this->optObj->getDsplLayout());
                if(!$theme){
                    return $content;
                }
                $theme->formPostData($result, $this->optObj, $ratings);

                $relContent = $theme->render();
                
		$this->setSuppressOthers();

		return $relContent;
	}

	/**
	 * Loads profile options from database and creates options object
	 * @return boolean true if profile was found, false otherwise
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
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
		$this->optObj->loadOptions($this->profile);

		return $this->optObj->isProfileLoaded();
	}

	/**
	 * @deprecated
	 * @return boolean
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since
	 */
	private function translateOptions() {
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
			return true;
		}
		return false;
	}

	private function setSuppressOthers() {
		// Setting supress others option
		erpPROPaths::requireOnce(erpPROPaths::$erpPROTemplates);
		if ( $this->optObj->getSuppressOthers() === true ) {
			erpPROTemplates::suppressOthers(true);
		} elseif ( $this->optObj->getSuppressOthers() === false) {
			erpPROTemplates::suppressOthers(false);
		}
	}
 }