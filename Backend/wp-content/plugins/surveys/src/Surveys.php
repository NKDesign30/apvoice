<?php

namespace apo\svy;
use apo\svy\Loader;
use apo\svy\cpt\Survey as SurveyCustomPostType;
use apo\svy\rest\SurveyRestFields;
use apo\svy\rest\Routes;

class Surveys {

	private static $instance;
	
	private $loader;
	private $surveyCustomPostType;
	private $routes;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof Surveys) {
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
		$this->surveyCustomPostType = new SurveyCustomPostType();
		$this->surveyRestFields = new SurveyRestFields();
		$this->routes = new Routes();
	}

	private function defineHooks() 
	{
		// init custom-post-types & meta boxes
		$this->loader->add_action('init', $this->surveyCustomPostType, 'register');
		$this->loader->add_action('init', $this, 'loadTextdomain');
		$this->loader->add_action('rest_api_init', $this->routes, 'register');
		$this->loader->add_action('rest_api_init', $this->surveyRestFields, 'register');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'svy', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'SVY_VERSION' ) ) {
			define( 'SVY_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'SVY_SLUG' ) ) {
			define( 'SVY_SLUG', 'svy_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'SVY_PLUGIN_DIR' ) ) {
			define( 'SVY_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'SVY_PLUGIN_URL' ) ) {
			define( 'SVY_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Public Template Folder Path
		if ( ! defined( 'SVY_PUBLIC_VIEW' ) ) {
			define( 'SVY_PUBLIC_VIEW', plugin_dir_path( __DIR__ ) . 'src/views/public/' );
		}

		// Admin Templates Folder Path
		if ( ! defined( 'SVY_ADMIN_VIEW' ) ) {
			define( 'SVY_ADMIN_VIEW', plugin_dir_path( __DIR__ ) . 'src/views/admin/' );
		}

		// Component Template Folder Path
		if ( ! defined( 'SVY_COMPONENT_VIEW' ) ) {
			define( 'SVY_COMPONENT_VIEW', plugin_dir_path( __DIR__ ) . 'src/views/component/' );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'SVY_FUNC_DIR' ) ) {
			define( 'SVY_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Assets Folder Path
		if ( ! defined( 'SVY_ASSETS_DIR' ) ) {
			define( 'SVY_ASSETS_DIR', plugin_dir_path( __DIR__ ) . 'assets/' );
		}

		// Assets Folder URL
		if ( ! defined( 'SVY_ASSETS_URL' ) ) {
			define( 'SVY_ASSETS_URL', plugin_dir_url( __DIR__ ) . 'assets/' );
		}

		// CSS Folder URL
		if ( ! defined( 'SVY_CSS_URL' ) ) {
			define( 'SVY_CSS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/css/' );
		}

		// JavaScript Folder URL
		if ( ! defined( 'SVY_JS_URL' ) ) {
			define( 'SVY_JS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/js/' );
		}

		// Images Folder URL
		if ( ! defined( 'SVY_IMG_URL' ) ) {
			define( 'SVY_IMG_URL', plugin_dir_url( __DIR__ ) . 'assets/img/' );
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
