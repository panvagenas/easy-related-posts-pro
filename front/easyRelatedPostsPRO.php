<?php


/**
 * Easy Related Posts PRO.
 *
 * @package Easy_Related_Posts
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license GPL-2.0+
 * @link http://example.com
 * @copyright 2014 Panagiotis Vagenas
 */

/**
 * Plugin class.
 *
 * @package Easy_related_posts
 * @author Your Name <email@example.com>
 */
class easyRelatedPostsPRO {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const VERSION = '1.0.0'; // erpPRODefaults::erpPROVersionString;

	/**
	 * Unique identifier for your plugin.
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $plugin_slug = ERP_PRO_SLUG;

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Main options class.
	 *
	 * @since 1.0.0
	 * @var erpPROMainOpts
	 */
	protected $widOpts;

	/**
	 * Widget options class.
	 *
	 * @since 1.0.0
	 * @var erpPROMainOpts
	 */
	protected $mainOpts;

	/**
	 * Default options class.
	 *
	 * @since 1.0.0
	 * @var erpPRODefaults
	 */
	protected $defOpts;

	/**
	 * Session object;
	 *
	 * @since 1.0.0
	 * @var WP_Session
	 */
	protected $wpSession;

	/**
	 * DB actions object
	 *
	 * @since 1.0.0
	 * @var erpPRODBActions
	 */
	protected $DB;

	/**
	 * If rating system is in use then this should be true
	 *
	 * @since 1.0.0
	 * @var boolean
	 */
	protected $ratingSystem;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since 1.0.0
	 */
	private function __construct( ) {
		// Dependencies
		erpPROPaths::requireOnce(erpPROPaths::$erpPRODBActions);
		erpPROPaths::requireOnce(erpPROPaths::$erpPROMainOpts);
		erpPROPaths::requireOnce(erpPROPaths::$erpPROWidOpts);
		erpPROPaths::requireOnce(erpPROPaths::$erpPROTracker);

		$this->wpSession = WP_Session::get_instance();
		$this->DB = erpPRODBActions::getInstance();

		$this->mainOpts = new erpPROMainOpts();
		$this->widOpts = new erpPROWidOpts();

		/**
		 * Check if rating system is on in order to call tracker
		 */
		if ( $this->isRatingSystemOn() ) {
			$tracker = new erpPROTracker( $this->DB, $this->wpSession );
			add_action( 'init', array (
					$tracker,
					'tracker'
			) );
		}
		/**
		 * Call content modifier
		 */
		add_filter( 'the_content', array (
				$this,
				'contentFilter'
		), 1000 );

		// Load plugin text domain
		add_action( 'init', array (
				$this,
				'load_plugin_textdomain'
		) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array (
				$this,
				'activate_new_site'
		) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array (
				$this,
				'enqueue_styles'
		) );
		add_action( 'wp_enqueue_scripts', array (
				$this,
				'enqueue_scripts'
		) );
	}

	/**
	 * Decides if content should be modified, if yes calls content modifier
	 *
	 * @param string $content
	 * @return string
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function contentFilter( $content ) {
		// TODO Remove debug
		// do_action('debug',__FUNCTION__.' started');
		global $post;
		/**
		 * Check if is time to take action
		 */
		if ( $this->isShowTime( $post ) && !$this->isInExcludedPostTypes( $post ) && !$this->isInExcludedTaxonomies( $post ) && ( bool ) $this->mainOpts->getValue( 'activate' ) ) {
			// TODO Remove debug
			do_action( 'debug', __FUNCTION__ . ' started' );

			erpPROPaths::requireOnce(erpPROPaths::$erpPROMainTemplates);
			erpPROPaths::requireOnce(erpPROPaths::$erpProRelated);

			$relatedObj = erpProRelated::get_instance( $this->mainOpts->getOptions() );
			$result = $relatedObj->getRelated( $post->ID );
			$ratings = $relatedObj->getRatingsFromRelDataObj();
			if ( empty( $result ) || empty( $result->posts ) ) {
				return $content;
			}

			$template = new erpPROMainTemplates();
			$template->load($this->mainOpts->getValue('dsplLayout'));
			if (!$template->isLoaded()) {
				return $content;
			}
			$relContent = $template->display( $result, $this->mainOpts, $ratings, false );

			// TODO Remove debug
			do_action( 'debug', __FUNCTION__ . ' returning rel content' );
			return $relContent . $content;
		}
		// TODO Remove debug
		// do_action('debug',__FUNCTION__.' returning def content');
		return $content;
	}

	/**
	 * Return the value of ratingsystem field
	 *
	 * @return boolean True iff rating system is in use
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function isRatingSystemOn( $overide = FALSE ) {
		if ( !isset( $this->ratingSystem ) ) {
			$this->ratingSystem = $overide || $this->mainOpts->checkRatingSystem() || $this->widOpts->checkRatingSystem();
		}
		return $this->ratingSystem;
	}

	/**
	 * Checks if current post belongs in an excluded post type
	 * TODO Maybe this should be in a class that will be accesible form other plugin components
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function isInExcludedPostTypes( $post ) {
		$postType = get_post_type( $post );
		if ( !empty( $postType ) && is_array( $this->mainOpts->getValue( 'postTypes' ) ) && in_array( $postType, $this->mainOpts->getValue( 'postTypes' ) ) ) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Checks if current post belongs in an excluded taxonimies
	 * TODO Maybe this should be in a class that will be accesible form other plugin components
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function isInExcludedTaxonomies( $post ) {
		$exCats = $this->mainOpts->getValue( 'categories' );

		if ( !empty( $exCats ) ) {
			$postCategories = get_the_category( $post->ID );
			if ( is_array( $postCategories ) && !empty( $postCategories ) ) {
				$catIds = array ();
				foreach ( $postCategories as $cat ) {
					array_push( $catIds, $cat->term_id );
				}
				$intersect = array_intersect( $catIds, $exCats );
				if ( !empty( $intersect) && count($intersect) == count($postCategories))  {
					return TRUE;
				}
			}
		}

		$exTags = $this->mainOpts->getValue( 'tags' );
		if ( !empty( $exTags ) ) {
			$postTags = get_the_tags( $post->ID );
			if ( is_array( $postTags ) && !empty( $postTags ) ) {
				$tagsIds = array ();
				foreach ( $postTags as $tag ) {
					array_push( $tagsIds, (string) $tag->term_id );
				}
				$intersect = array_intersect( $tagsIds, $exTags );
				if ( !empty( $intersect )  && count($intersect) == count($postTags)) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}

	/**
	 * Checks if it's time to display related
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function isShowTime( $post ) {
		if ( empty( $post ) || !is_single( $post->ID ) || !is_main_query() || !in_the_loop() ) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since 1.0.0
	 * @return Plugin slug variable.
	 */
	public function get_plugin_slug( ) {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return easyRelatedPostsPRO A single instance of this class.
	 */
	public static function get_instance( ) {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since 1.0.0
	 * @param boolean $network_wide
	 *        	True if WPMU superadmin uses
	 *        	"Network Activate" action, false if
	 *        	WPMU is disabled or plugin is
	 *        	activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();
			} else {
				self::single_activate();
			}
		} else {
			self::single_activate();
		}
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since 1.0.0
	 * @param boolean $network_wide
	 *        	True if WPMU superadmin uses
	 *        	"Network Deactivate" action, false if
	 *        	WPMU is disabled or plugin is
	 *        	deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();
				}

				restore_current_blog();
			} else {
				self::single_deactivate();
			}
		} else {
			self::single_deactivate();
		}
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since 1.0.0
	 * @param int $blog_id
	 *        	ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {
		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since 1.0.0
	 * @return array false blog ids, false if no matches.
	 */
	private static function get_blog_ids( ) {
		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
		WHERE archived = '0' AND spam = '0'
		AND deleted = '0'";

		return $wpdb->get_col( $sql );
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since 1.0.0
	 */
	private static function single_activate( ) {
		erpPROPaths::requireOnce(erpPROPaths::$erpPROActivator);

		$compareVersions = erpPRODefaults::compareVersion( get_option( ERP_PRO_SLUG . '_version' ) );
		if ( $compareVersions < 0 ) {
			erpPROActivator::createERPTable();
			erpPROActivator::addNonExistingMainOptions( erpPRODefaults::$comOpts + erpPRODefaults::$mainOpts );
			erpPROActivator::addNonExistingWidgetOptions( erpPRODefaults::$comOpts + erpPRODefaults::$widOpts );
			erpPRODefaults::updateVersionNumbers();
		} elseif ( $compareVersions === 0 ) {
			// Major update
		} elseif ( $compareVersions === 1 ) {
			// Release update
		} elseif ( $compareVersions === 2 ) {
			// Minor update
		}

		// Cron jobs
		wp_schedule_event( time(), 'weekly', 'erpPRO_weekly_event_hook' );
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since 1.0.0
	 */
	private static function single_deactivate( ) {
		wp_clear_scheduled_hook( 'erpPRO_weekly_event_hook' );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain( ) {
		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles( ) {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array (), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts( ) {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array (
				'jquery'
		), self::VERSION );
	}

	/**
	 * Adds once weekly to the existing schedules
	 *
	 * @param array $schedules
	 * @return array
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public static function addWeeklyCron( $schedules ) {
		$schedules [ 'weekly' ] = array (
				'interval' => 604800,
				'display' => __( 'Once Weekly' )
		);
		return $schedules;
	}

	/**
	 * Weekly cron job actions
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public static function weeklyCronJob( ) {
		// Clean up table
		global $wpdb;
		$query = 'DELETE FROM ' . $wpdb->prefix . ERP_PRO_RELATIVE_TABLE . ' WHERE time < "' . date( 'Y-m-d H:i:s', time() - 2419200 ) . '"';
		return $wpdb->query( $query );
	}
}