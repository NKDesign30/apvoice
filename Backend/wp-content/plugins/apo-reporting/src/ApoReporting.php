<?php

namespace apo\reporting;

use apo\reporting\Loader;
use apo\reporting\rest\Routes;
use apo\reporting\controllers\ReinsertDailyStatisticsController;

class ApoReporting {

	private static $instance;
	private $loader;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoReporting) {
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
		// init scripts & styles
		$this->loader->add_action('rest_api_init', $this->routes, 'register');
		$this->loader->add_action( 'admin_post_apo_reporting_reinsert_daily_statistics_form', new ReinsertDailyStatisticsController, 'store');
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
		if ( ! defined( 'APO_REPORTING_VERSION' ) ) {
			define( 'APO_REPORTING_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_REPORTING_SLUG' ) ) {
			define( 'APO_REPORTING_SLUG', 'apo_reporting_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_REPORTING_PLUGIN_DIR' ) ) {
			define( 'APO_REPORTING_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_REPORTING_PLUGIN_URL' ) ) {
			define( 'APO_REPORTING_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_REPORTING_FUNC_DIR' ) ) {
			define( 'APO_REPORTING_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Views Folder Path
		if ( ! defined( 'APO_REPORTING_VIEWS_DIR' ) ) {
			define( 'APO_REPORTING_VIEWS_DIR', plugin_dir_path( __DIR__ ) . 'src/views/' );
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
