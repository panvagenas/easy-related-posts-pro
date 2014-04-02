<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Options
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
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

	/**
	 * Loads the options from DB
	 *
	 * @return erpPROOptions
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	//public function loadOptions(  ) {}

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
		$this->options = array_merge( isset($this->options) ? $this->options : array(), $options );
		return $this;
	}

	public function getSortRelatedBy( ) {
		if ( isset( $this->options [ 'sortRelatedBy' ] ) ) {
			return erpPRODefaults::$sortRelatedByOptionSerialized [ erpPRODefaults::$sortKeys [ $this->options [ 'sortRelatedBy' ] ] ];
		}
		return erpPRODefaults::$sortRelatedByOptionSerialized [ 0 ];
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

	public function getTitle() {
		return $this->getValue('title');
	}

	public function getNumberOfPostsToDiplay() {
		return $this->getValue('numberOfPostsToDisplay');
	}

	public function getFetchBy() {
		return $this->getValue('fetchBy');
	}

	public function getOffset() {
		return $this->getValue('offset');
	}

	public function getContentPositioning() {
		return $this->getValue('content');
	}

	public function getSortRelatedBy() {
		return $this->getValue('sortRelatedBy');
	}

	public function getDefaultThumbnail() {
		return $this->getValue('defaultThumbnail');
	}

	public function getPostTitleFontSize() {
		return $this->getValue('postTitleFontSize');
	}

	public function getExcFontSize() {
		return $this->getValue('excFontSize');
	}

	public function getExcLength() {
		return $this->getValue('excLength');
	}

	public function getMoreTxt() {
		return $this->getValue('moreTxt');
	}

	public function getThumbnailHeight() {
		return $this->getValue('thumbnailHeight');
	}

	public function getThumbnailWidth() {
		return $this->getValue('thumbnailWidth');
	}

	public function getDsplThumbnail() {
		return $this->getValue('dsplThumbnail');
	}

	public function getCropThumbnail() {
		return $this->getValue('cropThumbnail');
	}

	public function getDsplLayout() {
		return $this->getValue('dsplLayout');
	}
}