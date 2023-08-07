<?php

namespace dwnld;

use dwnld\Loader;
use dwnld\rest\Routes;
use dwnld\rest\AwesomeRestFields;
use dwnld\cpt\Download as DownloadCustomPostType;
use dwnld\metaboxes\AwsmMetaBox;

class ApoDownloads {

	private static $instance;
	private $loader;
	private $awesomeCustomPostType;
	private $awesomeRestFields;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoDownloads) {
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
		$this->awesomeCustomPostType = new DownloadCustomPostType();
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
		if ( ! defined( 'DWNLD_VERSION' ) ) {
			define( 'DWNLD_VERSION', '0.0.1' );
		}

		// Plugin Slug
		if ( ! defined( 'DWNLD_SLUG' ) ) {
			define( 'DWNLD_SLUG', 'dwnld_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'DWNLD_PLUGIN_DIR' ) ) {
			define( 'DWNLD_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'DWNLD_PLUGIN_URL' ) ) {
			define( 'DWNLD_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'DWNLD_FUNC_DIR' ) ) {
			define( 'DWNLD_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Assets Folder Path
		if ( ! defined( 'DWNLD_ASSETS_DIR' ) ) {
			define( 'DWNLD_ASSETS_DIR', plugin_dir_path( __DIR__ ) . 'assets/' );
		}

		// Assets Folder URL
		if ( ! defined( 'DWNLD_ASSETS_URL' ) ) {
			define( 'DWNLD_ASSETS_URL', plugin_dir_url( __DIR__ ) . 'assets/' );
		}

		// CSS Folder URL
		if ( ! defined( 'DWNLD_CSS_URL' ) ) {
			define( 'DWNLD_CSS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/css/' );
		}

		// JavaScript Folder URL
		if ( ! defined( 'DWNLD_JS_URL' ) ) {
			define( 'DWNLD_JS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/js/' );
		}

		// Images Folder URL
		if ( ! defined( 'DWNLD_IMG_URL' ) ) {
			define( 'DWNLD_IMG_URL', plugin_dir_url( __DIR__ ) . 'assets/img/' );
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
