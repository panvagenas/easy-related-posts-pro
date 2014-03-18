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
 * Default options class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
class erpPRODefaults {

	/**
	 * Plugin version.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	const erpPROVersion = 1;

	/**
	 * Plugin release.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	const erpPRORelease = 0;

	/**
	 * Plugin subrelease.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	const erpPROSubRelease = 0;

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const erpPROVersionString = '1.0.0';

	/**
	 * If plugin uses the rating system
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	const erpPRORatingSystem = FALSE;

	/**
	 * This should be upddated if widget class name change
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const erpPROWidgetOptionsArrayName = 'erpprowidget';

	/**
	 * Sorting options
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public static $sortRelatedByOptionSerialized = array (
			"a:1:{s:4:'date';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}}",  // date desc
			"a:1:{s:4:'date';a:2:{s:5:'order';s:3:'asc';s:4:'rank';i:1;}}",  // date asc
			"a:1:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}}",  // rating desc
			"a:1:{s:6:'rating';a:2:{s:5:'order';s:3:'asc';s:4:'rank';i:1;}}",  // rating asc
			"a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:2;}s:4:'date';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}}",  // date desc rating desc
			"a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:2;}s:4:'date';a:2:{s:5:'order';s:3:'asc';s:4:'rank';i:1;}}",  // date asc rating desc
			"a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:2;}s:4:'date';a:2:{s:5:'order';s:3:'desc';s:4:'rank';i:1;}}",  // date desc rating asc
			"a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:2;}s:4:'date';a:2:{s:5:'order';s:3:'asc';s:4:'rank';i:1;}}",  // date asc rating asc
			"a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}s:4:'date';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:2;}}",  // rating desc date desc
			"a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}s:4:'date';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:2;}}",  // rating desc date asc
			"a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:1;}s:4:'date';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:2;}}",  // rating asc date desc
			"a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:1;}s:4:'date';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:2;}}"  // rating asc date asc
		);

	public static $sortRelatedByOption = array (
			array (
					'date' => array (
							'order' => 'desc',
							'rank' => 1
					)
			),
			array (
					'date' => array (
							'order' => 'asc',
							'rank' => 1
					)
			),
			array (
					'rating' => array (
							'order' => 'desc',
							'rank' => 1
					)
			),
			array (
					'rating' => array (
							'order' => 'asc',
							'rank' => 1
					)
			),
			array (
					'date' => array (
							'order' => 'desc',
							'rank' => 1
					),
					'rating' => array (
							'order' => 'desc',
							'rank' => 2
					)
			),
			array (
					'date' => array (
							'order' => 'asc',
							'rank' => 1
					),
					'rating' => array (
							'order' => 'desc',
							'rank' => 2
					)
			),
			array (
					'date' => array (
							'order' => 'desc',
							'rank' => 1
					),
					'rating' => array (
							'order' => 'asc',
							'rank' => 2
					)
			),
			array (
					'date' => array (
							'order' => 'asc',
							'rank' => 1
					),
					'rating' => array (
							'order' => 'asc',
							'rank' => 2
					)
			),
			array (
					'date' => array (
							'order' => 'desc',
							'rank' => 2
					),
					'rating' => array (
							'order' => 'desc',
							'rank' => 1
					)
			),
			array (
					'date' => array (
							'order' => 'asc',
							'rank' => 2
					),
					'rating' => array (
							'order' => 'desc',
							'rank' => 1
					)
			),
			array (
					'date' => array (
							'order' => 'desc',
							'rank' => 2
					),
					'rating' => array (
							'order' => 'asc',
							'rank' => 1
					)
			),
			array (
					'date' => array (
							'order' => 'asc',
							'rank' => 2
					),
					'rating' => array (
							'order' => 'asc',
							'rank' => 1
					)
			)
	);

	public static $sortKeys = array (
			'date_descending' => 0,
			'date_ascending' => 1,
			'rating_descending' => 2,
			'rating_ascending' => 3,
			'date_descending_then_rating_descending' => 4,
			'date_ascending_then_rating_descending' => 5,
			'date_descending_then_rating_ascending' => 6,
			'date_ascending_then_rating_ascending' => 7,
			'rating_descending_then_date_descending' => 8,
			'rating_ascending_then_date_descending' => 9,
			'rating_descending_then_date_ascending' => 10,
			'rating_ascending_then_date_ascending' => 11
	);

	/**
	 * Common options used from all components.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public static $comOpts = array (
			'title' => 'Easy Related Posts PRO',
			'numberOfPostsToDisplay' => 6,
			'fetchBy' => 'categories',
			'offset' => 0,
			'content' => 'post_title',
			'contentPositioning' => array (
					'thumbnail',
					'title',
					'excerpt'
			),
			'sortRelatedBy' => 'date_descending',
			'dsplThumbnail' => 1,
			'defaultThumbnail' => FALSE,  // TODO Set a default thumbnail
			'postTitleFontSize' => 0,
			'excFontSize' => 0,
			'excLength' => 150,
			'moreTxt' => ' ...read more',
			'thumbnailHeight' => 150,
			'thumbnailWidth' => 300,
			'dsplThumbnail' => 1,
			'cropThumbnail' => 1
	);

	/**
	 * Main plugin options
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public static $mainOpts = array (
			'activate' => 1,
			'dsplLayout' => 'grid',
			'categories' => array (),
			'tags' => array (),
			'postTypes' => array (
					'page',
					'attachment',
					'nav_menu_item',
					'revision'
			)
	);

	/**
	 * Widget options
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public static $widOpts = array (
			'dsplLayout' => 'basic',
			'postTitleColor' => '#ffffff',
			'excColor' => '#ffffff',
			'postTitleColorUse' => 0,
			'excColorUse' => 0,
			'hideIfNoPosts' => 0,
			'taxExclude' => 0,
			'ptypeExclude' => 0,
			'carouselAutoTime' => 2,
			'carouselDim' => 800,
			'carouselPauseHover' => true
	);

	/**
	 * Critical options, related result depends on them
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public static $criticalOpts = array (
			'fetchBy',
			'numberOfPostsToDisplay',
			'offset'
	// 'sortRelatedBy'
		);

	/**
	 * Compares the input string if matches plugin version
	 *
	 * @param string $version
	 * @return number -1 if input isn't string, else 0 if version differs, else 1 if release differs, else 2 if subrelease differs, else 3
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public static function compareVersion( $version ) {
		if ( !is_string( $version ) ) {
			return -1;
		}
		$vrs = explode( '.', $version, 3 );
		if ( count( $vrs ) < 3 ) {
			return -1;
		}
		if ( $vrs [ 0 ] != self::erpPROVersion ) {
			return 0;
		} elseif ( $vrs [ 1 ] != self::erpPRORelease ) {
			return 1;
		} elseif ( $vrs [ 2 ] != self::erpPROSubRelease ) {
			return 2;
		}
		return 3;
	}

	/**
	 * Updates version numbers in DB.
	 * If not present adds them.
	 *
	 * @return boolean
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public static function updateVersionNumbers( ) {
		return update_option( 'erpPROVersionNumbers', self::erpPROVersion . '.' . self::erpPRORelease . '.' . self::erpPROSubRelease );
	}
}