<?php

namespace apo\apopoints;

use apo\apopoints\Loader;
use apo\apopoints\rest\Routes;
use apo\apopoints\rest\UserRestFields;

class ApoApoPoints {

	private static $instance;
	private $loader;
	private $routes;
	private $userRestFields;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoApoPoints) {
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
		$this->defineConstans();
		$this->run();
	}

	private function loadDependencies() 
	{
		$this->loader = new Loader();
		$this->routes = new Routes();
		$this->userRestFields = new UserRestFields();
	}

	private function defineHooks() 
	{
		// init scripts & styles
		$this->loader->add_action('init', $this, 'loadTextdomain');
		$this->loader->add_action('rest_api_init', $this->routes, 'register');
		$this->loader->add_action('rest_api_init', $this->userRestFields, 'register');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'apo_apopoints', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function defineConstans() 
	{
		// Plugin version
		if ( ! defined( 'APO_APOPOINTS_VERSION' ) ) {
			define( 'APO_APOPOINTS_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_APOPOINTS_SLUG' ) ) {
			define( 'APO_APOPOINTS_SLUG', 'apo_apopoints_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_APOPOINTS_PLUGIN_DIR' ) ) {
			define( 'APO_APOPOINTS_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_APOPOINTS_PLUGIN_URL' ) ) {
			define( 'APO_APOPOINTS_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_APOPOINTS_FUNC_DIR' ) ) {
			define( 'APO_APOPOINTS_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Assets Folder Path
		if ( ! defined( 'APO_APOPOINTS_ASSETS_DIR' ) ) {
			define( 'APO_APOPOINTS_ASSETS_DIR', plugin_dir_path( __DIR__ ) . 'assets/' );
		}

		// Assets Folder URL
		if ( ! defined( 'APO_APOPOINTS_ASSETS_URL' ) ) {
			define( 'APO_APOPOINTS_ASSETS_URL', plugin_dir_url( __DIR__ ) . 'assets/' );
		}

		// CSS Folder URL
		if ( ! defined( 'APO_APOPOINTS_CSS_URL' ) ) {
			define( 'APO_APOPOINTS_CSS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/css/' );
		}

		// JavaScript Folder URL
		if ( ! defined( 'APO_APOPOINTS_JS_URL' ) ) {
			define( 'APO_APOPOINTS_JS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/js/' );
		}

		// Images Folder URL
		if ( ! defined( 'APO_APOPOINTS_IMG_URL' ) ) {
			define( 'APO_APOPOINTS_IMG_URL', plugin_dir_url( __DIR__ ) . 'assets/img/' );
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
