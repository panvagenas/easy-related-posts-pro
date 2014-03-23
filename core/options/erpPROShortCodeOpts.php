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
 * Shortcode options class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
class erpPROShortCodeOpts extends erpPROOptions {

	public function __construct( ) {
		parent::__construct();
		$this->optionsArrayName = 'shortCodeOptions';
	}

	public function loadOptions( Array $optionsArray ) {
		$this->options = $optionsArray;

// 		$this->ratingSytem = ( strpos( $this->options [ 'sortRelatedBy' ], 'rating' ) === false );
// 		if ( $this->ratingSytem && class_exists( 'easyRelatedPostsPRO' ) ) {
// 			$erp = easyRelatedPostsPRO::get_instance();
// 			$erp->defineRatingSystem( TRUE );
// 		}
	}

	public function loadShortCodeOptions(Array $optionsArray){
		$this->options = $optionsArray;
	}

	public function saveOptions( $newOptions ) {
		return false;
	}
}