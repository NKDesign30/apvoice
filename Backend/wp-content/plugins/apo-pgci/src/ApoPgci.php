<?php

namespace apo\pgci;

use apo\pgci\Loader;
use apo\pgci\controllers\PGCIUploadController;
use apo\pgci\controllers\PGCIBulkActionController;

class ApoPgci
{
	private static $instance;
	private $loader;

	/**
	* @return self
	*/
	public static function instance()
	{
		if( !self::$instance  && !self::$instance instanceof ApoPgci) {
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
		$this->loader->add_action( 'admin_post_apo_pgci_codes_form', new PGCIUploadController, 'update');
		$this->loader->add_action( 'admin_post_apo_pgci_bulk_action_form', new PGCIBulkActionController, 'action');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'apo-pgci', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'APO_PGCI_VERSION' ) ) {
			define( 'APO_PGCI_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_PGCI_SLUG' ) ) {
			define( 'APO_PGCI_SLUG', 'expert_codes_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_PGCI_PLUGIN_DIR' ) ) {
			define( 'APO_PGCI_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_PGCI_PLUGIN_URL' ) ) {
			define( 'APO_PGCI_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_PGCI_FUNC_DIR' ) ) {
			define( 'APO_PGCI_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

        // Views Folder Path
		if ( ! defined( 'APO_PGCI_VIEWS_DIR' ) ) {
			define( 'APO_PGCI_VIEWS_DIR', plugin_dir_path( __DIR__ ) . 'src/views/' );
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
