<?php
/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Admin
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

namespace admin;
/**
 * Plugin class.
 * This class should ideally be used to work with the
 * administrative side of the WordPress site.
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name.php`
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Plugin_Name_Admin
 * @author Your Name <email@example.com>
 */
class easyRelatedPostsPROAdmin {

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 * @var easyRelatedPostsPROAdmin
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since 1.0.0
	 */
	private function __construct( ) {

		/*
		 * @TODO : - Uncomment following lines if the admin class should only be available for super admins
		 */
		if ( !is_super_admin() ) {
			return;
		}

		/*
		 * Call $plugin_slug from public plugin class. @TODO: - Rename "Plugin_Name" to the name of your initial plugin class
		 */
		$plugin = easyRelatedPostsPRO::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array (
				$this,
				'enqueue_admin_styles'
		) );
		add_action( 'admin_enqueue_scripts', array (
				$this,
				'enqueue_admin_scripts'
		) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array (
				$this,
				'add_plugin_admin_menu'
		) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array (
				$this,
				'add_action_links'
		) );

		// Save options
		add_action( 'admin_post_save_' . EPR_PRO_MAIN_OPTIONS_ARRAY_NAME, array (
				$this,
				'saveOptions'
		) );

		// Do rating when saving new posts
		// TODO Remove 1
		if ( $plugin->isRatingSystemOn() ) {
			// TODO This action should be fired only with permited post types. This can be done with variable action hooks
			// save_post_{$post->post_type} http://adambrown.info/p/wp_hooks/hook/save_post_%7B$post-%3Epost_type%7D
			add_action( 'save_post', array (
					$this,
					'doRating'
			) );
		}

		/**
		 * Ajax hooks
		 */
		add_action( 'wp_ajax_loadTemplateOptions', array (
				$this,
				'loadTemplateOptions'
		) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return object A single instance of this class.
	 */
	public static function get_instance( ) {

		/*
		 * @TODO : - Uncomment following lines if the admin class should only be available for super admins
		 */
		if ( !is_super_admin() ) {
			return;
		}

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function doRating( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		require_once erpPRODefaults::getPath( 'related' );
		require_once erpPRODefaults::getPath( 'options' );

		$opts = new erpPROMainOpts();

		$opts->setOptions( array (
				'queryLimit' => 300
		) );
		$rel = erpProRelated::get_instance( $opts->getOptions() );

		$rel->doRating( $post_id );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 * @TODO:
	 * - Rename "Plugin_Name" to the name your plugin
	 *
	 * @since 1.0.0
	 * @return null Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles( ) {
		if ( !isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id || 'widgets' == $screen->id ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( $this->plugin_slug . '-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array (), easyRelatedPostsPRO::VERSION );
			wp_enqueue_style( $this->plugin_slug . '-qtip', plugins_url( 'assets/css/jquery.qtip-min.css', __FILE__ ), array (), easyRelatedPostsPRO::VERSION );
		}
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 * @TODO:
	 * - Rename "Plugin_Name" to the name your plugin
	 *
	 * @since 1.0.0
	 * @return null Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts( ) {
		if ( !isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id || 'widgets' == $screen->id) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'jquery-effects-fade' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( $this->plugin_slug . '-qtip', plugins_url( 'assets/js/jquery.qtip.min.js', __FILE__ ), array (
					'jquery'
			), easyRelatedPostsPRO::VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array (
					'jquery', 'jquery-ui-tabs', $this->plugin_slug . '-qtip'
			), easyRelatedPostsPRO::VERSION );
		}
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-main-settings', plugins_url( 'assets/js/mainSettings.js', __FILE__ ), array (
					$this->plugin_slug . '-admin-script'
			), easyRelatedPostsPRO::VERSION );
		}
		if ( 'widgets' == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-widget-settings', plugins_url( 'assets/js/widgetSettings.js', __FILE__ ), array (
					$this->plugin_slug . '-admin-script'
			), easyRelatedPostsPRO::VERSION );
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since 1.0.0
	 */
	public function add_plugin_admin_menu( ) {

		/*
		 * Add a settings page for this plugin to the Settings menu. NOTE: Alternative menu locations are available via WordPress administration menu functions. Administration Menus: http://codex.wordpress.org/Administration_Menus @TODO: - Change 'Page Title' to the title of your plugin admin page - Change 'Menu Text' to the text for menu item for the plugin settings page - Change 'manage_options' to the capability you see fit For reference: http://codex.wordpress.org/Roles_and_Capabilities
		 */
		$this->plugin_screen_hook_suffix = add_options_page( __( 'Easy Related Posts PRO Settings', $this->plugin_slug ), __( 'Easy Related Posts PRO Settings', $this->plugin_slug ), 'manage_options', $this->plugin_slug . '_settings', array (
				$this,
				'display_plugin_admin_page'
		) );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_admin_page( ) {
		if ( !class_exists( 'erpPROView' ) ) {
			require_once erpPRODefaults::getPath( 'viewer' );
		}
		$defaultOptions = erpPRODefaults::$mainOpts + erpPRODefaults::$comOpts;
		$optObj = new erpPROMainOpts();
		$options = $optObj->getOptions();

		$viewData [ 'erpPROOptions' ] = is_array( $options ) ? array_merge( $defaultOptions, $options ) : $defaultOptions;

		erpPROView::render( plugin_dir_path( __FILE__ ) . 'views/admin.php', $viewData, TRUE );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since 1.0.0
	 */
	public function add_action_links( $links ) {
		return array_merge( array (
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
		), $links );
	}
	/**
	 * Saves admin options. This is called through a hook
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function saveOptions( ) {
		if ( !current_user_can( 'manage_options' ) ) {
			wp_die( 'Not allowed' );
		}
		require_once erpPRODefaults::getPath( 'options' );
		// Save template options
		if ( isset( $_POST [ 'dsplLayout' ] ) ) {
			erpPROHelper::requireFileHelper();
			require_once erpPRODefaults::getPath( 'templates' );
			$templateXMLPath = erpPROFileHelper::getTemplateXMLPath( $_POST [ 'dsplLayout' ], erpPRODefaults::getPath( 'mainTemplates' ) );
			$templateObj = new erpPROTemplates( $templateXMLPath );
			$templateObj->saveTemplateOptions( $_POST );
			$templateOptions = $templateObj->getOptions();
			foreach ( $templateOptions as $key => $value ) {
				unset( $_POST [ $key ] );
			}
		}
		// Save the rest of the options
		$mainOptionsObj = new erpPROMainOpts();
		$mainOptionsObj->saveOptions( $_POST );
		wp_redirect( add_query_arg( array (
				'page' => $this->plugin_slug . '_settings',
				'tab-spec' => wp_strip_all_tags( $_POST [ 'tab-spec' ] )
		), admin_url( 'options-general.php' ) ) );
		exit();
	}
	/**
	 * This is called through ajax hook and returns the plugin options as defined in template settings file
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function loadTemplateOptions() {
		if (!isset($_POST['template']) || !isset($_POST['templateRoot'])) {
			echo json_encode('false');
			die();
		}
		require_once erpPRODefaults::getPath('templates');
		erpPROHelper::requireFileHelper();

		$templateXMLPath = erpPROFileHelper::getTemplateXMLPath($_POST['template'], $_POST['templateRoot']);

		$templateObj = new erpPROTemplates($templateXMLPath);
		$data = array(
			'content' => $templateObj->renderSettings(false),
				'optionValues' => $templateObj->getOptions()
		);

		echo json_encode($data);
		die();
	}
}
