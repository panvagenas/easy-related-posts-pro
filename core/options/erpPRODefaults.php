<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Options
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

/**
 * Default options class.
 *
 * @package Easy_Related_Posts_Options
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPRODefaults {

    const intFormal = 'int';
    const floatFormal = 'float';
    const stringFormal = 'string';
    const arrayFormal = 'array';
    const boolFormal = 'bool';
//    const licence = 'licence';

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
    const erpPROSubRelease = 2;

    /**
     * Plugin version, used for cache-busting of style and script file references.
     *
     * @since 1.0.0
     * @var string
     */
    const erpPROVersionString = '1.0.2';
    
    /**
     * This should be updated if widget class name change
     *
     * @since 1.0.0
     * @var string
     */
    const erpPROWidgetOptionsArrayName = 'erpprowidget';

    /**
     * Version number is stored in DB as a WP option. 
     * This is the name of the option
     *
     * @since 1.0.0
     * @var string
     */
    const versionNumOptName = 'erpPROVersionNumbers';

    /**
     * Sorting options
     *
     * @since 1.0.0
     * @var array
     */
    public static $sortRelatedByOptionSerialized = array(
        "a:1:{s:4:'date';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}}", // date desc
        "a:1:{s:4:'date';a:2:{s:5:'order';s:3:'asc';s:4:'rank';i:1;}}", // date asc
        "a:1:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}}", // rating desc
        "a:1:{s:6:'rating';a:2:{s:5:'order';s:3:'asc';s:4:'rank';i:1;}}", // rating asc
        "a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:2;}s:4:'date';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}}", // date desc rating desc
        "a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:2;}s:4:'date';a:2:{s:5:'order';s:3:'asc';s:4:'rank';i:1;}}", // date asc rating desc
        "a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:2;}s:4:'date';a:2:{s:5:'order';s:3:'desc';s:4:'rank';i:1;}}", // date desc rating asc
        "a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:2;}s:4:'date';a:2:{s:5:'order';s:3:'asc';s:4:'rank';i:1;}}", // date asc rating asc
        "a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}s:4:'date';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:2;}}", // rating desc date desc
        "a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:1;}s:4:'date';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:2;}}", // rating desc date asc
        "a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:1;}s:4:'date';a:2:{s:5:'order';s:4:'desc';s:4:'rank';i:2;}}", // rating asc date desc
        "a:2:{s:6:'rating';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:1;}s:4:'date';a:2:{s:5:'order';s:4:'asc';s:4:'rank';i:2;}}"
    ); // rating asc date asc

    /**
     * Options available for related storting
     *
     * @since 1.0.0
     * @var array
     */
    public static $sortRelatedByOption = array(
        array(
            'date' => array(
                'order' => 'desc',
                'rank' => 1
            )
        ),
        array(
            'date' => array(
                'order' => 'asc',
                'rank' => 1
            )
        ),
        array(
            'rating' => array(
                'order' => 'desc',
                'rank' => 1
            )
        ),
        array(
            'rating' => array(
                'order' => 'asc',
                'rank' => 1
            )
        ),
        array(
            'date' => array(
                'order' => 'desc',
                'rank' => 1
            ),
            'rating' => array(
                'order' => 'desc',
                'rank' => 2
            )
        ),
        array(
            'date' => array(
                'order' => 'asc',
                'rank' => 1
            ),
            'rating' => array(
                'order' => 'desc',
                'rank' => 2
            )
        ),
        array(
            'date' => array(
                'order' => 'desc',
                'rank' => 1
            ),
            'rating' => array(
                'order' => 'asc',
                'rank' => 2
            )
        ),
        array(
            'date' => array(
                'order' => 'asc',
                'rank' => 1
            ),
            'rating' => array(
                'order' => 'asc',
                'rank' => 2
            )
        ),
        array(
            'date' => array(
                'order' => 'desc',
                'rank' => 2
            ),
            'rating' => array(
                'order' => 'desc',
                'rank' => 1
            )
        ),
        array(
            'date' => array(
                'order' => 'asc',
                'rank' => 2
            ),
            'rating' => array(
                'order' => 'desc',
                'rank' => 1
            )
        ),
        array(
            'date' => array(
                'order' => 'desc',
                'rank' => 2
            ),
            'rating' => array(
                'order' => 'asc',
                'rank' => 1
            )
        ),
        array(
            'date' => array(
                'order' => 'asc',
                'rank' => 2
            ),
            'rating' => array(
                'order' => 'asc',
                'rank' => 1
            )
        )
    );

    /**
     * Sortkeys (sort_key_string => $indexInSortOptionsArrays)
     *
     * @since 1.0.0
     * @var array
     */
    public static $sortKeys = array(
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
     * Options for related fetching options
     *
     * @since 1.0.0
     * @var array
     */
    public static $fetchByOptions = array(
        'Categories',
        'Tags',
        'Categories first, then tags',
        'Tags first, then categories'
    );

    /**
     * Fetch by weights
     * @var array
     */
    public static $fetchByOptionsWeights = array(
        'categories' => array('clicks' => 0.15, 'categories' => 0.85, 'tags' => 0.0),
        'tags' => array('clicks' => 0.15, 'categories' => 0.0, 'tags' => 0.85),
        'categories_first_then_tags' => array('clicks' => 0.15, 'categories' => 0.60, 'tags' => 0.25),
        'tags_first_then_categories' => array('clicks' => 0.15, 'categories' => 0.25, 'tags' => 0.60)
    );

    /**
     * Content positioning options
     * @var array  
     */
    public static $contentPositioningOptions = array(
        'Title',
        'Thumbnail',
        'Excerpt',
        'Title, excerpt',
        'Title, thumbnail',
        'Thumbnail, title',
        'Thumbnail, title, excerpt',
        'Title, thumbnail, excerpt',
        'Title, excerpt, thumbnail'
    );

    /**
     * Common options used from all components.
     *
     * @since 1.0.0
     * @var array
     */
    public static $comOpts = array(
        'title' => 'Easy Related Posts PRO',
        'numberOfPostsToDisplay' => 6,
        'fetchBy' => 'categories',
        'offset' => 0,
        'content' => array(
            'thumbnail',
            'title',
            'excerpt'
        ),
        'sortRelatedBy' => 'date_descending',
        'defaultThumbnail' => EPR_PRO_DEFAULT_THUMBNAIL,
        'postTitleFontSize' => 0,
        'excFontSize' => 0,
        'excLength' => 15,
        'moreTxt' => ' ...read more',
        'thumbnailHeight' => 150,
        'thumbnailWidth' => 300,
        'cropThumbnail' => true,
        'postTitleColor' => '#ffffff',
        'excColor' => '#ffffff',
        'entropy' => 0
    );

    /**
     * Used for options validation. Does not contain values for options but types
     *
     * @since 1.0.0
     * @var array
     */
    public static $comOptsValidations = array(
        'title' => array('type' => self::stringFormal),
        'numberOfPostsToDisplay' => array('type' => self::intFormal, 'min' => 1),
        'fetchBy' => array('type' => self::stringFormal),
        'offset' => array('type' => self::intFormal, 'min' => 0),
        'content' => array('type' => self::arrayFormal),
        'sortRelatedBy' => array('type' => self::stringFormal),
        'defaultThumbnail' => array('type' => self::stringFormal),
        'postTitleFontSize' => array('type' => self::intFormal, 'min' => 0),
        'excFontSize' => array('type' => self::intFormal, 'min' => 0),
        'excLength' => array('type' => self::intFormal, 'min' => 1),
        'moreTxt' => array('type' => self::stringFormal),
        'thumbnailHeight' => array('type' => self::intFormal, 'min' => 0),
        'thumbnailWidth' => array('type' => self::intFormal, 'min' => 0),
        'cropThumbnail' => array('type' => self::boolFormal),
        'postTitleColor' => array('type' => self::stringFormal),
        'excColor' => array('type' => self::stringFormal),
        'entropy' => array('type' => self::floatFormal, 'min' => 0, 'max' => 1),
    );

    /**
     * Main plugin options
     *
     * @since 1.0.0
     * @var array
     */
    public static $mainOpts = array(
        'activate' => true,
        'dsplLayout' => 'Grid',
        'categories' => array(),
        'tags' => array(),
        'postTypes' => array(
            'page',
            'attachment',
            'nav_menu_item',
            'revision'
        ),
        'relPosition' => 'bottom',
        'disableTrackingSystem' => false,
//        'licence' => '',
//        'licenceStatus' => false
    );

    /**
     * Used for options validation. Does not contain values for options but types
     *
     * @since 1.0.0
     * @var array
     */
    public static $mainOptsValidations = array(
        'activate' => array('type' => self::boolFormal),
        'dsplLayout' => array('type' => self::stringFormal),
        'categories' => array('type' => self::arrayFormal),
        'tags' => array('type' => self::arrayFormal),
        'postTypes' => array('type' => self::arrayFormal),
        'relPosition' => array('type' => self::stringFormal),
        'disableTrackingSystem' => array('type' => self::boolFormal),
//        'licence' => array('type' => self::licence),
//        'licenceStatus' => array('type' => self::boolFormal),
    );

    /**
     * Widget options
     *
     * @since 1.0.0
     * @var array
     */
    public static $widOpts = array(
        'dsplLayout' => 'Basic',
        'hideIfNoPosts' => false,
    );

    /**
     * Used for options validation. Does not contain values for options but types
     *
     * @since 1.0.0
     * @var array
     */
    public static $widOptsValidations = array(
        'dsplLayout' => array('type' => self::stringFormal),
        'hideIfNoPosts' => array('type' => self::boolFormal),
    );

    /**
     * Shortcode options
     *
     * @since 1.0.0
     * @var array
     */
    public static $shortCodeOpts = array(
        'suppressOthers' => false,
        'dsplLayout' => 'Grid',
        'postTitleColor' => '#ffffff',
        'excColor' => '#ffffff',
        'hideIfNoPosts' => false,
        'categories' => array(),
        'tags' => array(),
        'postTypes' => array(
            'page',
            'attachment',
            'nav_menu_item',
            'revision'
        )
    );

    /**
     * Used for options validation. Does not contain values for options but types
     *
     * @since 1.0.0
     * @var array
     */
    public static $shortcodeOptsValidations = array(
        'suppressOthers' => array('type' => self::boolFormal),
        'dsplLayout' => array('type' => self::stringFormal),
        'postTitleColor' => array('type' => self::stringFormal),
        'excColor' => array('type' => self::stringFormal),
        'hideIfNoPosts' => array('type' => self::boolFormal),
        'categories' => array('type' => self::arrayFormal),
        'tags' => array('type' => self::arrayFormal),
        'postTypes' => array('type' => self::arrayFormal)
    );

    /**
     * Critical options, related result depends on them
     *
     * @since 1.0.0
     * @var array
     */
    public static $criticalOpts = array(
        'fetchBy',
        'numberOfPostsToDisplay',
        'offset',
        'entropy'
            // 'sortRelatedBy'
    );

    /**
     * Compares the input string if matches plugin version
     *
     * @param string $version
     * @return number -1 if input isn't string, else 0 if version differs, else 1 if release differs, else 2 if subrelease differs, else 3
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public static function compareVersion($version) {
        if (!is_string($version)) {
            return -1;
        }
        $vrs = explode('.', $version, 3);
        if (count($vrs) < 3) {
            return -1;
        }
        if ($vrs [0] != self::erpPROVersion) {
            return 0;
        } elseif ($vrs [1] != self::erpPRORelease) {
            return 1;
        } elseif ($vrs [2] != self::erpPROSubRelease) {
            return 2;
        }
        return 3;
    }

    /**
     * Updates version numbers in DB.
     * If not present adds them.
     *
     * @return boolean
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public static function updateVersionNumbers() {
        return update_option(self::versionNumOptName, self::erpPROVersion . '.' . self::erpPRORelease . '.' . self::erpPROSubRelease);
    }

}
