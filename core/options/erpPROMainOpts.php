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

erpPROPaths::requireOnce(erpPROPaths::$erpPROOptions);
/**
 * Main plugin options class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
class erpPROMainOpts extends erpPROOptions {

	public function __construct( ) {
		$this->optionsArrayName = EPR_PRO_MAIN_OPTIONS_ARRAY_NAME;
		$this->loadOptions();
		parent::__construct();
	}

	public function loadOptions( ) {
		$this->options = get_option( $this->optionsArrayName );
	}

	// public function getTemplatePath() {
	// return parent::getTemplatePath(erpPRODefaults::getPath('mainTemplates'));
	// }

	/**
	 * Deletes a single option from options array in DB
	 *
	 * @param string $optionName
	 *        	Option name
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function deleteOption( $optionName ) {
		if ( $this->optionsArrayName === NULL ) {
			return FALSE;
		}
		$value = parent::deleteOption( $optionName );
		if ( $value !== NULL ) {
			if ( update_option( $this->optionsArrayName, $this->options ) ) {
				return TRUE;
			}
			$this->options [ $optionName ] = $value;
		}
		return FALSE;
	}

	/**
	 * Checks all plugin instances if they use rating system
	 *
	 * @return boolean True if any instance uses rating system, false otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
// 	public function checkRatingSystem( ) {
// 		if ( empty( $this->options ) ) {
// 			$this->loadOptions();
// 		}
// 		$this->ratingSytem = isset( $this->options [ 'sortRelatedBy' ] ) ? ( strpos( $this->options [ 'sortRelatedBy' ], 'rating' ) === false ) : false;
// 		return $this->ratingSytem;
// 	}

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
		if ( isset( $newOptions [ 'content' ] ) ) {
			$this->options [ 'content' ] = explode('-', strip_tags($newOptions [ 'content' ]) );
		}
		if ( isset( $newOptions [ 'sortRelatedBy' ] ) ) {
			$this->options [ 'sortRelatedBy' ] = strip_tags( $newOptions [ 'sortRelatedBy' ] );
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

		if ( isset( $newOptions [ 'activate' ] ) ) {
			$this->options [ 'activate' ] = true;
		} else {
			$this->options [ 'activate' ] = false;
		}
		if ( isset( $newOptions [ 'numOfPostsPerRow' ] ) && $newOptions [ 'numOfPostsPerRow' ] > 0 ) {
			$this->options [ 'numOfPostsPerRow' ] = ( int ) $newOptions [ 'numOfPostsPerRow' ];
		}
		if ( isset( $newOptions [ 'popPos' ] ) ) {
			$this->options [ 'popPos' ] = strip_tags( $newOptions [ 'popPos' ] );
		}
		if ( isset( $newOptions [ 'popColor' ] ) ) {
			$this->options [ 'popColor' ] = strip_tags( $newOptions [ 'popColor' ] );
		}
		if ( isset( $newOptions [ 'popTriger' ] ) && $newOptions [ 'popTriger' ] > 0 ) {
			$this->options [ 'popTriger' ] = ( float ) $newOptions [ 'popTriger' ];
		}
		if ( isset( $newOptions [ 'popBkgTrns' ] ) && $newOptions [ 'popBkgTrns' ] > 0 ) {
			$this->options [ 'popBkgTrns' ] = ( float ) $newOptions [ 'popBkgTrns' ];
		}
		if ( isset( $newOptions [ 'dsplLayout' ] ) ) {
			$this->options [ 'dsplLayout' ] = strip_tags( $newOptions [ 'dsplLayout' ] );
		}
		if ( isset( $newOptions [ 'categories' ] ) ) {
			$this->options [ 'categories' ] = ( array ) $newOptions [ 'categories' ];
		} else {
			$this->options [ 'categories' ] = array();
		}
		if ( isset( $newOptions [ 'tags' ] ) ) {
			$this->options [ 'tags' ] = ( array ) $newOptions [ 'tags' ];
		} else {
			$this->options [ 'tags' ] = array();
		}
		if ( isset( $newOptions [ 'postTypes' ] ) ) {
			$this->options [ 'postTypes' ] = ( array ) $newOptions [ 'postTypes' ];
		} else {
			$this->options [ 'postTypes' ] = array();
		}
		update_option( $this->optionsArrayName, $this->options );
	}
}