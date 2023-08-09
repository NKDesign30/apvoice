<?php

namespace apo\bonago;

use apo\bonago\Loader;
use apo\bonago\controllers\VoucherUploadController;
use apo\bonago\rest\Routes;
use apo\bonago\controllers\VoucherBulkActionController;

class ApoBonago
{
	private static $instance;
	private $loader;
	private $routes;

	/**
	* @return self
	*/
	public static function instance()
	{
		if( !self::$instance  && !self::$instance instanceof ApoBonago) {
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
		$this->loader->add_action( 'admin_post_apo_bonago_voucher_codes_form', new VoucherUploadController, 'update');
		$this->loader->add_action( 'admin_post_apo_bonago_bulk_action_form', new VoucherBulkActionController, 'action');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'apovoice-bonago', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'APO_BONAGO_VERSION' ) ) {
			define( 'APO_BONAGO_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_BONAGO_SLUG' ) ) {
			define( 'APO_BONAGO_SLUG', 'apo_bonago_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_BONAGO_PLUGIN_DIR' ) ) {
			define( 'APO_BONAGO_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_BONAGO_PLUGIN_URL' ) ) {
			define( 'APO_BONAGO_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_BONAGO_FUNC_DIR' ) ) {
			define( 'APO_BONAGO_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

        // Views Folder Path
		if ( ! defined( 'APO_BONAGO_VIEWS_DIR' ) ) {
			define( 'APO_BONAGO_VIEWS_DIR', plugin_dir_path( __DIR__ ) . 'src/views/' );
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
