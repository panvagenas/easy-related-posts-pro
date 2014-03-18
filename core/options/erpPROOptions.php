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
namespace options;

use helpers\erpPROPaths;

/**
 * Options abstract class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
abstract class erpPROOptions {

	protected $options = NULL;

	protected $ratingSytem = NULL;

	protected $optionsArrayName = NULL;

	public function __construct( ) {
		$this->ratingSytem = isset( $this->options [ 'sortRelatedBy' ] ) ? ( bool ) strpos( $this->options [ 'sortRelatedBy' ], 'rating' ) : false;
	}

	// public function getTemplatePath($templatesPath){
	// erpPROPaths::requireOnce(erpPROPaths::$erpPROFileHelper);
	// $templates = erpPROFileHelper::dirToArray(erpPRODefaults::getPath('mainTemplates'));
	// $templateFolder = '';
	// foreach ($templates as $key => $value) {
	// if (strcasecmp(str_replace('_', ' ', $this->options['dsplLayout']), $value) === 0) {
	// $templateFolder = $value;
	// break;
	// }
	// }
	// return $templatesPath . '/' . $templateFolder . '/' . $this->options['dsplLayout'] . '.php';
	// }

	/**
	 * Loads the options from DB
	 *
	 * @return erpPROOptions
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function loadOptions( Array $optionsArray ) {}

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
		$this->options = array_merge( $this->options, $options );
		return $this;
	}

	/**
	 * Saves common options to db
	 *
	 * @param unknown $newOptions
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function saveOptions( $newOptions ) {
		if ( isset( $newOptions [ 'title' ] ) ) {
			$this->options [ 'title' ] = strip_tags( $newOptions [ 'title' ] );
		}
		if ( isset( $newOptions [ 'numberOfPostsToDisplay' ] ) && $newOptions [ 'numberOfPostsToDisplay' ] > 0 ) {
			$this->options [ 'numberOfPostsToDisplay' ] = ( int ) $newOptions [ 'numberOfPostsToDisplay' ];
		}
		if ( isset( $newOptions [ 'fetchBy' ] ) ) {
			$this->options [ 'fetchBy' ] = strip_tags( $newOptions [ 'fetchBy' ] );
		}
		if ( isset( $newOptions [ 'offset' ] ) && $newOptions [ 'offset' ] >= 0 ) {
			$this->options [ 'offset' ] = ( int ) $newOptions [ 'offset' ];
		}
		if ( isset( $newOptions [ 'contentPositioning' ] ) ) {
			$this->options [ 'contentPositioning' ] = strip_tags( $newOptions [ 'contentPositioning' ] );
		}
		if ( isset( $newOptions [ 'sortRelatedBy' ] ) ) {
			$this->options [ 'sortRelatedBy' ] = strip_tags( $newOptions [ 'sortRelatedBy' ] );
		}
		if ( isset( $newOptions [ 'dsplThumbnail' ] ) ) {
			$this->options [ 'dsplThumbnail' ] = true;
		} else {
			$this->options [ 'dsplThumbnail' ] = false;
		}
		if ( isset( $newOptions [ 'postTitleFontSize' ] ) && $newOptions [ 'postTitleFontSize' ] >= 0 ) {
			$this->options [ 'postTitleFontSize' ] = ( int ) $newOptions [ 'postTitleFontSize' ];
		}
		if ( isset( $newOptions [ 'excFontSize' ] ) && $newOptions [ 'excFontSize' ] >= 0 ) {
			$this->options [ 'excFontSize' ] = ( int ) $newOptions [ 'excFontSize' ];
		}
		if ( isset( $newOptions [ 'excLength' ] ) && $newOptions [ 'excLength' ] > 0 ) {
			$this->options [ 'excLength' ] = ( int ) $newOptions [ 'excLength' ];
		}
		if ( isset( $newOptions [ 'moreTxt' ] ) ) {
			$this->options [ 'moreTxt' ] = strip_tags( $newOptions [ 'moreTxt' ] );
		}
		if ( isset( $newOptions [ 'thumbnailHeight' ] ) && $newOptions [ 'thumbnailHeight' ] > 0 ) {
			$this->options [ 'thumbnailHeight' ] = ( int ) $newOptions [ 'thumbnailHeight' ];
		}
		if ( isset( $newOptions [ 'thumbnailWidth' ] ) && $newOptions [ 'thumbnailWidth' ] > 0 ) {
			$this->options [ 'thumbnailWidth' ] = ( int ) $newOptions [ 'thumbnailWidth' ];
		}
		if ( isset( $newOptions [ 'cropThumbnail' ] ) ) {
			$this->options [ 'cropThumbnail' ] = true;
		} else {
			$this->options [ 'cropThumbnail' ] = false;
		}
		update_option( $this->optionsArrayName, $this->options );
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
	 * @return null string NULL if option not found, option value otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getValue( $optionName ) {
		return isset( $this->options [ $optionName ] ) ? $this->options [ $optionName ] : NULL;
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
	public function isRatingSystemOn( ) {
		return $this->ratingSytem === NULL ? FALSE : $this->ratingSytem;
	}

	/**
	 * Checks if specified option exists
	 *
	 * @param string $optName
	 * @return boolean True if option is set, false otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since
	 *
	 *
	 *
	 *
	 */
	public function isOptionSet( $optName ) {
		return isset( $this->options [ $optName ] ) ? TRUE : FALSE;
	}
}