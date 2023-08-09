<?php

namespace apo\fuzzysearch;

use apo\fuzzysearch\Loader;
use apo\fuzzysearch\rest\Routes;

class ApoFuzzySearch {

	private static $instance;
	private $loader;
    private $routes;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoFuzzySearch) {
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
	}

	private function defineHooks() 
	{
		$this->loader->add_action('init', $this, 'loadTextdomain');
        $this->loader->add_action('rest_api_init', $this->routes, 'register');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'apo_fuzzy_search', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'APO_FUZZY_SEARCH_VERSION' ) ) {
			define( 'APO_FUZZY_SEARCH_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_FUZZY_SEARCH_SLUG' ) ) {
			define( 'APO_FUZZY_SEARCH_SLUG', 'apo_fuzzysearch_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_FUZZY_SEARCH_PLUGIN_DIR' ) ) {
			define( 'APO_FUZZY_SEARCH_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_FUZZY_SEARCH_PLUGIN_URL' ) ) {
			define( 'APO_FUZZY_SEARCH_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_FUZZY_SEARCH_FUNC_DIR' ) ) {
			define( 'APO_FUZZY_SEARCH_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Indexes Folder Path
		if ( ! defined( 'APO_FUZZY_SEARCH_INDEXES_DIR' ) ) {
			define( 'APO_FUZZY_SEARCH_INDEXES_DIR', plugin_dir_path( __DIR__ ) . 'assets/indexes/' . get_locale() . '/');
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
