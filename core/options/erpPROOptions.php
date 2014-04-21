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

/**
 * Options abstract class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
abstract class erpPROOptions {

	protected $options = NULL;

	protected $defaults;

	/**
	 * @deprecated
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	protected $ratingSytem = NULL;

	protected $optionsArrayName = NULL;

	public function __construct( ) {
		$this->ratingSytem = isset( $this->options [ 'sortRelatedBy' ] ) ? ( bool ) strpos( $this->options [ 'sortRelatedBy' ], 'rating' ) : false;
		$this->defaults = &erpPRODefaults::$comOpts;
	}
	
	public function getOptionsArrayName() {
	    return $this->optionsArrayName;
	}

	/**
	 * Get option array
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 * @return array Options array
	 */
	public function getOptions( ) {
		return $this->options;
	}

	/**
	 * Sets options in instance options array.
	 * !IMPORTAND! Won't update options in DB, just sets them in instance options array.
	 *
	 * @param array $options
	 *        	New options as associative array
	 * @return erpPROOptions
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function setOptions( $options ) {
		$this->options = array_merge( isset($this->options) ? (array)$this->options : array(), $options );
		return $this;
	}

	public function getSortRelatedBy( $unserializeIt = false ) {
		$i = isset( $this->options [ 'sortRelatedBy' ] ) ? erpPRODefaults::$sortKeys [ $this->options [ 'sortRelatedBy' ] ] : 0;

		return (bool)$unserializeIt ? erpPRODefaults::$sortRelatedByOption[$i] : erpPRODefaults::$sortRelatedByOptionSerialized[$i];
	}

	/**
	 * Get the value of given option.
	 *
	 * @param string $optionName
	 * @return null string NULL if option not found, option value otherwise (uses default value if avail)
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getValue( $optionName ) {
		if ($this->isOptionSet($optionName)) {
			return $this->options[$optionName];
		} elseif (isset($this->defaults[$optionName])) {
			return $this->defaults[$optionName];
		} else {
			return null;
		}
	}

	/**
	 * Just unsets option value if present in objects instance options array
	 *
	 * @return boolean Deleted option value if exists, NULL otherwise
	 * @since 1.0.0
	 */
	public function deleteOption( $optionName ) {
		if ( array_key_exists( $optionName, $this->options ) ) {
			$this->options [ $optionName ] = $value;
			unset( $this->options [ $optionName ] );
			return $value;
		}
		return NULL;
	}

	/**
	 * Returns rating system field value.
	 * Instance scope
	 *
	 * @return boolean
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
// 	public function isRatingSystemOn( ) {
// 		// TODO This no longer should be considered since all posts are rated
// 		return $this->ratingSytem === NULL ? FALSE : $this->ratingSytem;
// 	}

	/**
	 * Checks if specified option exists
	 *
	 * @param string $optName
	 * @return boolean True if option is set, false otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function isOptionSet( $optName ) {
		return isset( $this->options [ $optName ] );
	}

	/************************************************************************
	 * Option validation
	************************************************************************/
	protected function validInt($value) {
		return (int)$value;
	}
	protected function validString($value) {
		if (is_array((string)unserialize($value))) {
			return (string)$value;
		}
		if (filter_var($value, FILTER_VALIDATE_URL)) {
			if (strpos($value, get_site_url()) === false) {
				return null;
			}
		}
		return wp_strip_all_tags((string)$value);
	}
	protected function validFloat($value) {
		return (float)$value;
	}
	protected function validArray($value) {
		if (is_string($value)) {
			$unser = unserialize($value);
			if (is_array($unser)) {
				return $unser;
			}
			return explode('-', strip_tags($value) );
		}
		return (array)$value;
	}
	protected function validBool($value) {
		return (bool)$value;
	}

	/**
	 * Validates common options
	 *
	 * @param array $options New options
	 * @return array Assoc array containg only the validated options
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function validateCommonOptions( Array $options ) {
		return $this->switchValidationTypes($options, erpPRODefaults::$comOptsValidations);
	}

	/**
	 * Validates options and adds missing ones
	 *
	 * @param array $options
	 * @param array $types
	 * @return array
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	protected function switchValidationTypes($options, $types){
		$validated = array ();
		// Validate options that are set
		foreach ( $options as $key => $value ) {
			if ( isset( $types [ $key ] ) ) {
				switch ( $types [ $key ]['type'] ) {
					case erpPRODefaults::intFormal :
						$val = $this->validInt( $value );
						if (isset($types[$key]['min']) && $val < $types[$key]['min']) {
							break;
						}
						if (isset($types[$key]['max']) && $val > $types[$key]['max']) {
							break;
						}
						$validated [ $key ] = $val;
						break;
					case erpPRODefaults::stringFormal :
						$validated [ $key ] = $this->validString( $value );
						break;
					case erpPRODefaults::floatFormal :
						$validated [ $key ] = $this->validFloat( $value );
						break;
					case erpPRODefaults::arrayFormal :
						$validated [ $key ] = $this->validArray( $value );
						break;
					case erpPRODefaults::boolFormal :
						$validated [ $key ] = $this->validBool( $value );
						break;
					default:
						break;
				}
				unset($types[$key]);
			}
		}

		// Add options that are not set
		foreach ($types as $key => $value) {
			switch ( $value['type'] ) {
				case erpPRODefaults::intFormal :
					if (isset($this->defaults[$key])) {
						$validated[$key] = $this->defaults[$key];
					} elseif (isset($value['min'])) {
						$validated[$key] = $value['min'];
					}
					break;
				case erpPRODefaults::stringFormal :
					if (isset($this->defaults[$key])) {
						$validated[$key] = $this->defaults[$key];
					}
					break;
				case erpPRODefaults::floatFormal :
					if (isset($this->defaults[$key])) {
						$validated[$key] = $this->defaults[$key];
					} elseif (isset($value['min'])) {
						$validated[$key] = $value['min'];
					}
					break;
				case erpPRODefaults::arrayFormal :
					$validated[$key] = array();
					break;
				case erpPRODefaults::boolFormal :
					$validated [ $key ] = false;
					break;
				default:
					break;
			}
		}

		return $validated;
	}

	/************************************************************************
	 * Geters for options
	************************************************************************/

	/**
	 * If we have to display the post thumb
	 * @return boolean
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function haveToShowThumbnail() {
		return isset($this->options['content']) && in_array('thumbnail', $this->options['content']);
	}

	/**
	 * If we have to display the post excerpt
	 * @return boolean
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function haveToShowExcerpt() {
		return $this->isOptionSet('content') && in_array('excerpt', $this->options['content']);
	}

	/**
	 * Get title form settings
	 *
	 * @return string|null
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getTitle() {
		return $this->getValue('title');
	}

	/**
	 * Get number of posts to display
	 *
	 * @return int|null
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getNumberOfPostsToDiplay() {
		return $this->getValue('numberOfPostsToDisplay');
	}

	/**
	 * Get fetchBy option
	 *
	 * @return string|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getFetchBy() {
		return $this->getValue('fetchBy');
	}

	/**
	 * Get offset value
	 *
	 * @return int|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getOffset() {
		return $this->getValue('offset');
	}

	/**
	 * Get content array
	 *
	 * @return array|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getContentPositioning() {
		return $this->getValue('content');
	}

	/**
	 * Get default thumb url
	 * @return string|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getDefaultThumbnail() {
		return $this->getValue('defaultThumbnail');
	}

	/**
	 * Get rel post title font size
	 * @return int|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getPostTitleFontSize() {
		return $this->getValue('postTitleFontSize');
	}

	/**
	 * Get rel post exc font size
	 * @return int|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getExcFontSize() {
		return $this->getValue('excFontSize');
	}

	/**
	 * Get rel post exc length
	 * @return int|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getExcLength() {
		return $this->getValue('excLength');
	}

	/**
	 * Get more text
	 *
	 * @return string|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getMoreTxt() {
		return $this->getValue('moreTxt');
	}

	/**
	 * Get thumbnail height
	 *
	 * @return int|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getThumbnailHeight() {
		return $this->getValue('thumbnailHeight');
	}

	/**
	 * Get thumbnail width
	 *
	 * @return int|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getThumbnailWidth() {
		return $this->getValue('thumbnailWidth');
	}

	/**
	 * @deprecated Use haveToShowThumbnail instead
	 * @return bool|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getDsplThumbnail() {
		return $this->getValue('dsplThumbnail');
	}

	/**
	 * Get crop thumb value
	 * @return bool|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getCropThumbnail() {
		return $this->getValue('cropThumbnail');
	}

	/**
	 * Get display layout value
	 * @return string|NULL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getDsplLayout() {
		return $this->getValue('dsplLayout');
	}
}