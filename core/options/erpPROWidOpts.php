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
 * Widget options class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
class erpPROWidOpts extends erpPROOptions {

	public function __construct( Array $instance = NULL ) {
		$this->optionsArrayName = 'widget_' . erpPRODefaults::erpPROWidgetOptionsArrayName;

		if ( $instance !== NULL && !empty( $instance ) ) {
			$this->options = $instance;
		}
// 		$this->ratingSytem = $this->checkRatingSystem();
	}

	/**
	 * Checks all plugin instances if they use rating system
	 *
	 * @return boolean True if any instance uses rating system, false otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
// 	public function checkRatingSystem( ) {
// 		$DBOptionsArray = get_option( $this->optionsArrayName );
// 		$this->ratingSytem = false;
// 		if ( is_array( $DBOptionsArray ) ) {
// 			foreach ( $DBOptionsArray as $key => $value ) {
// 				if ( is_array( $value ) && array_key_exists( 'sortRelatedBy', $value ) ) {
// 					$this->ratingSytem = $this->ratingSytem || ( strpos( $value [ 'sortRelatedBy' ], 'rating' ) === false );
// 				}
// 			}
// 		}
// 		return $this->ratingSytem;
// 	}

	public function saveOptions( $new_instance, $old_instance ) {
		$instance = $old_instance + erpPRODefaults::$comOpts + erpPRODefaults::$widOpts;

		if ( isset( $new_instance [ 'title' ] ) ) {
			$instance [ 'title' ] = strip_tags( $new_instance [ 'title' ] );
		}
		if ( is_numeric( $new_instance [ "numberOfPostsToDisplay" ] ) && $new_instance [ "numberOfPostsToDisplay" ] > 0 ) {
			$instance [ 'numberOfPostsToDisplay' ] = $new_instance [ 'numberOfPostsToDisplay' ];
		}
		if ( is_numeric( $new_instance [ "offset" ] ) && $new_instance [ "offset" ] > -1 ) {
			$instance [ 'offset' ] = $new_instance [ 'offset' ];
		}
		if ( isset( $new_instance [ 'fetchBy' ] ) ) {
			$instance [ 'fetchBy' ] = strip_tags( $new_instance [ 'fetchBy' ] );
		}
		if ( isset( $new_instance [ 'content' ] ) ) {
			$instance [ 'content' ] = explode('-', strip_tags($new_instance [ 'content' ]) );
		}
		if ( isset( $new_instance [ "hideIfNoPosts" ] ) ) {
			$instance [ 'hideIfNoPosts' ] = ( bool ) $new_instance [ "hideIfNoPosts" ] ? 1 : 0;
		} else {
			$instance [ 'hideIfNoPosts' ] = false;
		}
		if ( isset( $new_instance [ "postTitleFontSize" ] ) && is_numeric( $new_instance [ "postTitleFontSize" ] ) && $new_instance [ "postTitleFontSize" ] > -1 ) {
			$instance [ 'postTitleFontSize' ] = $new_instance [ 'postTitleFontSize' ];
		}
		if ( isset( $new_instance [ "postTitleColor" ] ) ) {
			$instance [ 'postTitleColor' ] = strip_tags( $new_instance [ "postTitleColor" ] );
		}
		if ( isset( $new_instance [ "postTitleColorUse" ] ) ) {
			$instance [ 'postTitleColorUse' ] = ( bool ) $new_instance [ "postTitleColorUse" ] ? 1 : 0;
		} else {
			$instance [ 'postTitleColorUse' ] = false;
		}
		if ( isset( $new_instance [ "excFontSize" ] ) && is_numeric( $new_instance [ "excFontSize" ] ) && $new_instance [ "excFontSize" ] > -1 ) {
			$instance [ 'excFontSize' ] = $new_instance [ 'excFontSize' ];
		}
		if ( isset( $new_instance [ "excColor" ] ) ) {
			$instance [ 'excColor' ] = strip_tags( $new_instance [ "excColor" ] );
		}
		if ( isset( $new_instance [ "excColorUse" ] ) ) {
			$instance [ 'excColorUse' ] = ( bool ) $new_instance [ "excColorUse" ] ? 1 : 0;
		} else {
			$instance [ 'excColorUse' ] = false;
		}
		if ( isset( $new_instance [ "cropThumbnail" ] ) ) {
			$instance [ 'cropThumbnail' ] = ( bool ) $new_instance [ "cropThumbnail" ] ? 1 : 0;
		} else {
			$instance [ 'cropThumbnail' ] = false;
		}
		if ( isset( $new_instance [ "thumbnailHeight" ] ) && is_numeric( $new_instance [ "thumbnailHeight" ] ) && $new_instance [ "thumbnailHeight" ] > 0 ) {
			$instance [ 'thumbnailHeight' ] = $new_instance [ 'thumbnailHeight' ];
		}
		if ( isset( $new_instance [ "thumbnailWidth" ] ) && is_numeric( $new_instance [ "thumbnailWidth" ] ) && $new_instance [ "thumbnailWidth" ] > 0 ) {
			$instance [ 'thumbnailWidth' ] = $new_instance [ 'thumbnailWidth' ];
		}
		if ( isset( $new_instance [ "taxExclude" ] ) ) {
			$instance [ 'taxExclude' ] = ( bool ) $new_instance [ "taxExclude" ] ? 1 : 0;
		} else {
			$instance [ 'taxExclude' ] = false;
		}
		if ( isset( $new_instance [ "ptypeExclude" ] ) ) {
			$instance [ 'ptypeExclude' ] = ( bool ) $new_instance [ "ptypeExclude" ] ? 1 : 0;
		} else {
			$instance [ 'ptypeExclude' ] = false;
		}
		if ( isset( $new_instance [ 'dsplLayout' ] ) ) {
			$instance [ 'dsplLayout' ] = strip_tags( $new_instance [ "dsplLayout" ] );
		}
		if ( isset( $new_instance [ 'defaultThumbnail' ] ) && strpos( $new_instance [ 'defaultThumbnail' ], get_home_url() ) !== FALSE ) {
			$instance [ 'defaultThumbnail' ] = esc_url( $new_instance [ 'defaultThumbnail' ] );
		}
		if ( isset( $new_instance [ 'sortRelatedBy' ] ) ) {
			$instance [ 'sortRelatedBy' ] = strip_tags( $new_instance [ 'sortRelatedBy' ] );
		}
		return $instance;
	}
}