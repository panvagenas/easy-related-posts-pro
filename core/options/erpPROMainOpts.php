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

/**
 * Main plugin options class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
class erpPROMainOpts extends erpPROOptions {

	public function __construct( ) {
		parent::__construct();
		$this->optionsArrayName = EPR_PRO_MAIN_OPTIONS_ARRAY_NAME;
		$this->loadOptions();
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
	public function checkRatingSystem( ) {
		if ( empty( $this->options ) ) {
			$this->loadOptions();
		}
		$this->ratingSytem = isset( $this->options [ 'sortRelatedBy' ] ) ? ( strpos( $this->options [ 'sortRelatedBy' ], 'rating' ) === false ) : false;
		return $this->ratingSytem;
	}

	public function saveOptions( $newOptions ) {
		parent::saveOptions( $newOptions );

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
		if ( isset( $newOptionse [ 'categories' ] ) ) {
			$this->options [ 'categories' ] = ( array ) $newOptions [ 'categories' ];
		}
		if ( isset( $newOptionse [ 'tags' ] ) ) {
			$this->options [ 'tags' ] = ( array ) $newOptions [ 'tags' ];
		}
		if ( isset( $newOptionse [ 'postTypes' ] ) ) {
			$this->options [ 'postTypes' ] = ( array ) $newOptions [ 'postTypes' ];
		}
		update_option( $this->optionsArrayName, $this->options );
	}
}