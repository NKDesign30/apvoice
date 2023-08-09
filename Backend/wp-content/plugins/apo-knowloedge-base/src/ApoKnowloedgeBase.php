<?php

namespace knwldg;

use knwldg\Loader;
use knwldg\rest\Routes;
use knwldg\rest\AwesomeRestFields;
use knwldg\cpt\KnowledgeBase as KnowledgeBaseCustomPostType;
use knwldg\metaboxes\AwsmMetaBox;

class ApoKnowloedgeBase {

	private static $instance;
	private $loader;
	private $awesomeCustomPostType;
	private $awesomeRestFields;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoKnowloedgeBase) {
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
		$this->awesomeCustomPostType = new KnowledgeBaseCustomPostType();
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
		if ( ! defined( 'KNWLDG_VERSION' ) ) {
			define( 'KNWLDG_VERSION', '0.0.1' );
		}

		// Plugin Slug
		if ( ! defined( 'KNWLDG_SLUG' ) ) {
			define( 'KNWLDG_SLUG', 'knwldg_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'KNWLDG_PLUGIN_DIR' ) ) {
			define( 'KNWLDG_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'KNWLDG_PLUGIN_URL' ) ) {
			define( 'KNWLDG_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'KNWLDG_FUNC_DIR' ) ) {
			define( 'KNWLDG_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Assets Folder Path
		if ( ! defined( 'KNWLDG_ASSETS_DIR' ) ) {
			define( 'KNWLDG_ASSETS_DIR', plugin_dir_path( __DIR__ ) . 'assets/' );
		}

		// Assets Folder URL
		if ( ! defined( 'KNWLDG_ASSETS_URL' ) ) {
			define( 'KNWLDG_ASSETS_URL', plugin_dir_url( __DIR__ ) . 'assets/' );
		}

		// CSS Folder URL
		if ( ! defined( 'KNWLDG_CSS_URL' ) ) {
			define( 'KNWLDG_CSS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/css/' );
		}

		// JavaScript Folder URL
		if ( ! defined( 'KNWLDG_JS_URL' ) ) {
			define( 'KNWLDG_JS_URL', plugin_dir_url( __DIR__ ) . 'assets/dist/js/' );
		}

		// Images Folder URL
		if ( ! defined( 'KNWLDG_IMG_URL' ) ) {
			define( 'KNWLDG_IMG_URL', plugin_dir_url( __DIR__ ) . 'assets/img/' );
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
