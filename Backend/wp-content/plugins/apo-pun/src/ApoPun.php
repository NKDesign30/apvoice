<?php

namespace apo\pun;

use apo\pun\Loader;
use apo\pun\controllers\PUNUploadController;
use apo\pun\controllers\PUNBulkActionController;

class ApoPun
{
	private static $instance;
	private $loader;

	/**
	* @return self
	*/
	public static function instance()
	{
		if( !self::$instance  && !self::$instance instanceof ApoPun) {
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
		$this->loader->add_action( 'admin_post_apo_pun_codes_form', new PUNUploadController, 'update');
		$this->loader->add_action( 'admin_post_apo_pun_bulk_action_form', new PUNBulkActionController, 'action');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'apo-pun', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'APO_PUN_VERSION' ) ) {
			define( 'APO_PUN_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_PUN_SLUG' ) ) {
			define( 'APO_PUN_SLUG', 'expert_codes_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_PUN_PLUGIN_DIR' ) ) {
			define( 'APO_PUN_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_PUN_PLUGIN_URL' ) ) {
			define( 'APO_PUN_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_PUN_FUNC_DIR' ) ) {
			define( 'APO_PUN_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

        // Views Folder Path
		if ( ! defined( 'APO_PUN_VIEWS_DIR' ) ) {
			define( 'APO_PUN_VIEWS_DIR', plugin_dir_path( __DIR__ ) . 'src/views/' );
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
