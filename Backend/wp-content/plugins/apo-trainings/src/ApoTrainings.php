<?php

namespace apo\trng;

use apo\trng\Loader;
use apo\trng\rest\Routes;
use apo\trng\rest\TrainingRestFields;
use apo\trng\rest\TrainingSeriesRestFields;
use apo\trng\cpt\Training as TrainingCustomPostType;
use apo\trng\cpt\TrainingSeries as TrainingSeriesCustomPostType;

class ApoTrainings {

	private static $instance;
	private $loader;
	private $trainingRestFields;
	private $trainingSeriesRestFields;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoTrainings) {
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
		$this->trainingRestFields = new TrainingRestFields();
		$this->trainingSeriesRestFields = new TrainingSeriesRestFields();
	}

	private function defineHooks() 
	{
		// init scripts & styles
		$this->loader->add_action('init', new TrainingSeriesCustomPostType, 'register');
		$this->loader->add_action('init', new TrainingCustomPostType, 'register');
		$this->loader->add_action('init', $this, 'loadTextdomain');
		$this->loader->add_action('rest_api_init', $this->routes, 'register');
		$this->loader->add_action('rest_api_init', $this->trainingRestFields, 'register');
		$this->loader->add_action('rest_api_init', $this->trainingSeriesRestFields, 'register');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'trng', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'TRNG_VERSION' ) ) {
			define( 'TRNG_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'TRNG_SLUG' ) ) {
			define( 'TRNG_SLUG', 'trng_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'TRNG_PLUGIN_DIR' ) ) {
			define( 'TRNG_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'TRNG_PLUGIN_URL' ) ) {
			define( 'TRNG_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'TRNG_FUNC_DIR' ) ) {
			define( 'TRNG_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Assets Folder Path
		if ( ! defined( 'TRNG_ASSETS_DIR' ) ) {
			define( 'TRNG_ASSETS_DIR', plugin_dir_path( __DIR__ ) . 'assets/' );
		}

		// Assets Folder URL
		if ( ! defined( 'TRNG_ASSETS_URL' ) ) {
			define( 'TRNG_ASSETS_URL', plugin_dir_url( __DIR__ ) . 'assets/' );
		}

		// CSS Folder URL
		if ( ! defined( 'TRNG_CSS_URL' ) ) {
			define( 'TRNG_CSS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/css/' );
		}

		// JavaScript Folder URL
		if ( ! defined( 'TRNG_JS_URL' ) ) {
			define( 'TRNG_JS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/js/' );
		}

		// Images Folder URL
		if ( ! defined( 'TRNG_IMG_URL' ) ) {
			define( 'TRNG_IMG_URL', plugin_dir_url( __DIR__ ) . 'assets/img/' );
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
