<?php

namespace apo\expertcodes;

use apo\expertcodes\Loader;
use apo\expertcodes\controllers\ExpertCodesController;
use apo\expertcodes\controllers\ExpertCodesBulkActionController;

class ApoExpertCodes
{
	private static $instance;
	private $loader;

	/**
	* @return self
	*/
	public static function instance()
	{
		if( !self::$instance  && !self::$instance instanceof ApoExpertCodes) {
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
	}

	private function defineHooks()
	{
		$this->loader->add_action('init', $this, 'loadTextdomain');
		$this->loader->add_action( 'plugins_loaded', new ExpertCodesController, 'init' );
		$this->loader->add_action( 'admin_post_apo_expert_codes_bulk_action_form', new ExpertCodesBulkActionController, 'action');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'apovoice-expert-codes', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'APO_EXPERT_CODES_VERSION' ) ) {
			define( 'APO_EXPERT_CODES_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_EXPERT_CODES_SLUG' ) ) {
			define( 'APO_EXPERT_CODES_SLUG', 'expert_codes_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_EXPERT_CODES_PLUGIN_DIR' ) ) {
			define( 'APO_EXPERT_CODES_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_EXPERT_CODES_PLUGIN_URL' ) ) {
			define( 'APO_EXPERT_CODES_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_EXPERT_CODES_FUNC_DIR' ) ) {
			define( 'APO_EXPERT_CODES_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

        // Views Folder Path
		if ( ! defined( 'APO_EXPERT_CODES_VIEWS_DIR' ) ) {
			define( 'APO_EXPERT_CODES_VIEWS_DIR', plugin_dir_path( __DIR__ ) . 'src/views/' );
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
