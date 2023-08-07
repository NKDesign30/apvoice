<?php

namespace apo\rxts;
use apo\rxts\Loader;
use apo\rxts\rest\Routes;
use apo\rxts\rest\UserRestFields;
use apo\rxts\policies\ResponsePolicy;
use apo\rxts\metaboxes\UserAccessPermissions;
use apo\rxts\middleware\Middleware;
use apo\rxts\policies\ApiRoutePolicy;
use awsm\wp\libraries\utilities\RoutesCollector;

class RestExtensions {

	private static $instance;

	private $loader;
    private $routes;
    private $userAccessPermissions;

	/**
	* @return self
	*/
	public static function instance()
	{
		if( !self::$instance  && !self::$instance instanceof RestExtensions) {
			self::$instance = new static();
			self::$instance->setup();
		}
		return self::$instance;
	}

	/**
	 * build the plugin
	 */
	private function setup()
	{
		$this->loadDependencies();
		$this->defineHooks();
        $this->defineConstants();
		$this->defineFilters();
		$this->definePublicRoutes();
		$this->run();
	}

	private function loadDependencies()
	{
		$this->loader = new Loader();
		// $this->surveyRestFields = new SurveyRestFields();
		$this->routes = new Routes();
		$this->userAccessPermissions = new UserAccessPermissions();
	}

	private function defineHooks()
	{
		$this->loader->add_action('init', $this, 'loadTextdomain');

		$this->loader->add_action( 'rest_api_init', new ApiRoutePolicy(), 'protect', 9, 1);
		$this->loader->add_action( 'rest_api_init', new Middleware(), 'initialize', 10, 1);

		// init custom-post-types & meta boxes
		$this->loader->add_action('rest_api_init', $this->routes, 'register');
		$this->loader->add_action('rest_api_init', new UserRestFields(), 'register');

		$this->loader->add_action( 'add_meta_boxes', $this->userAccessPermissions, 'add' );
		$this->loader->add_action( 'save_post', $this->userAccessPermissions, 'save' );
	}

	private function defineFilters() {
		$this->loader->add_filter( 'rest_request_after_callbacks', new ResponsePolicy(), 'protect', 10, 3 );
	}
	
	private function definePublicRoutes()
	{
		/**
		 * add here all routes that should be public available
		 */
		$publicRoutes = [
			'/jwt-auth/v1/token',
            '/pid/login',
		];

		RoutesCollector::instance()->collectPublicRoute($publicRoutes);
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'rxts', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function defineConstants()
	{
		// Plugin version
		if ( ! defined( 'RXTS_VERSION' ) ) {
			define( 'RXTS_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'RXTS_SLUG' ) ) {
			define( 'RXTS_SLUG', 'rxts_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'RXTS_PLUGIN_DIR' ) ) {
			define( 'RXTS_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'RXTS_PLUGIN_URL' ) ) {
			define( 'RXTS_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Public Template Folder Path
		if ( ! defined( 'RXTS_PUBLIC_VIEW' ) ) {
			define( 'RXTS_PUBLIC_VIEW', plugin_dir_path( __DIR__ ) . 'src/views/public/' );
		}

		// Admin Templates Folder Path
		if ( ! defined( 'RXTS_ADMIN_VIEW' ) ) {
			define( 'RXTS_ADMIN_VIEW', plugin_dir_path( __DIR__ ) . 'src/views/admin/' );
		}

		// Component Template Folder Path
		if ( ! defined( 'RXTS_COMPONENT_VIEW' ) ) {
			define( 'RXTS_COMPONENT_VIEW', plugin_dir_path( __DIR__ ) . 'src/views/component/' );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'RXTS_FUNC_DIR' ) ) {
			define( 'RXTS_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Assets Folder Path
		if ( ! defined( 'RXTS_ASSETS_DIR' ) ) {
			define( 'RXTS_ASSETS_DIR', plugin_dir_path( __DIR__ ) . 'assets/' );
		}

		// Assets Folder URL
		if ( ! defined( 'RXTS_ASSETS_URL' ) ) {
			define( 'RXTS_ASSETS_URL', plugin_dir_url( __DIR__ ) . 'assets/' );
		}

		// CSS Folder URL
		if ( ! defined( 'RXTS_CSS_URL' ) ) {
			define( 'RXTS_CSS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/css/' );
		}

		// JavaScript Folder URL
		if ( ! defined( 'RXTS_JS_URL' ) ) {
			define( 'RXTS_JS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/js/' );
		}

		// Images Folder URL
		if ( ! defined( 'RXTS_IMG_URL' ) ) {
			define( 'RXTS_IMG_URL', plugin_dir_url( __DIR__ ) . 'assets/img/' );
		}

    }

	/**
	 * initialized all action hooks and filters and run the plugin
	 */
	private function run()
	{
		$this->loader->run();
	}

}
