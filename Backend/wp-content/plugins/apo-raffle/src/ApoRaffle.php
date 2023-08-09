<?php

namespace raffle;

use raffle\Loader;
use raffle\rest\Routes;
use raffle\rest\AwesomeRestFields;
use raffle\cpt\Raffle as RaffleCustomPostType;
use raffle\metaboxes\AwsmMetaBox;

class ApoRaffle {

	private static $instance;
	private $loader;
	private $awesomeCustomPostType;
	private $awesomeRestFields;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoRaffle) {
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
		$this->awesomeCustomPostType = new RaffleCustomPostType();
		$this->routes = new Routes();
		$this->awesomeRestFields = new AwesomeRestFields();
		$this->awsmMetaBox = new AwsmMetaBox();
	}

	private function defineHooks() 
	{
		// init scripts & styles
		$this->loader->add_action('init', $this->awesomeCustomPostType, 'register');
		$this->loader->add_action('rest_api_init', $this->routes, 'register');
		$this->loader->add_action('rest_api_init', $this->awesomeRestFields, 'register');
		$this->loader->add_action( 'wp_enqueue_scripts', $this->loader, 'initScripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->loader, 'initBackendScripts' );

		$this->loader->add_action( 'add_meta_boxes', $this->awsmMetaBox, 'add' );
		$this->loader->add_action( 'save_post', $this->awsmMetaBox, 'save' );
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
		if ( ! defined( 'RAFFLE_VERSION' ) ) {
			define( 'RAFFLE_VERSION', '0.0.1' );
		}

		// Plugin Slug
		if ( ! defined( 'RAFFLE_SLUG' ) ) {
			define( 'RAFFLE_SLUG', 'raffle_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'RAFFLE_PLUGIN_DIR' ) ) {
			define( 'RAFFLE_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'RAFFLE_PLUGIN_URL' ) ) {
			define( 'RAFFLE_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'RAFFLE_FUNC_DIR' ) ) {
			define( 'RAFFLE_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Assets Folder Path
		if ( ! defined( 'RAFFLE_ASSETS_DIR' ) ) {
			define( 'RAFFLE_ASSETS_DIR', plugin_dir_path( __DIR__ ) . 'assets/' );
		}

		// Assets Folder URL
		if ( ! defined( 'RAFFLE_ASSETS_URL' ) ) {
			define( 'RAFFLE_ASSETS_URL', plugin_dir_url( __DIR__ ) . 'assets/' );
		}

		// CSS Folder URL
		if ( ! defined( 'RAFFLE_CSS_URL' ) ) {
			define( 'RAFFLE_CSS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/css/' );
		}

		// JavaScript Folder URL
		if ( ! defined( 'RAFFLE_JS_URL' ) ) {
			define( 'RAFFLE_JS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/js/' );
		}

		// Images Folder URL
		if ( ! defined( 'RAFFLE_IMG_URL' ) ) {
			define( 'RAFFLE_IMG_URL', plugin_dir_url( __DIR__ ) . 'assets/img/' );
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
