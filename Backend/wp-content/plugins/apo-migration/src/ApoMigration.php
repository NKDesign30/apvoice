<?php

namespace apo\migration;

use apo\migration\Loader;
use apo\migration\controllers\MigrationController;
use apo\migration\controllers\MigrationDownloadController;

class ApoMigration {

	private static $instance;
	private $loader;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoMigration) {
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
		$this->loader->add_action( 'admin_enqueue_scripts', $this->loader, 'initBackendScripts' );
		$this->loader->add_action( 'admin_post_apo_migration_process_merge_form', new MigrationController, 'handle');
		$this->loader->add_action( 'admin_post_apo_migration_download_mapper_files_form', new MigrationDownloadController, 'download');
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
		if ( ! defined( 'APO_MIGRATION_VERSION' ) ) {
			define( 'APO_MIGRATION_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_MIGRATION_SLUG' ) ) {
			define( 'APO_MIGRATION_SLUG', 'apo_migration' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_MIGRATION_PLUGIN_DIR' ) ) {
			define( 'APO_MIGRATION_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_MIGRATION_PLUGIN_URL' ) ) {
			define( 'APO_MIGRATION_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_MIGRATION_FUNC_DIR' ) ) {
			define( 'APO_MIGRATION_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
		}

		// Database migration assets
		if ( ! defined( 'APO_MIGRATION_ASSETS' ) ) {
			define( 'APO_MIGRATION_ASSETS', plugin_dir_path( __DIR__ ) . 'src/assets/migration/');
		}

		 // Views Folder Path
		 if ( ! defined( 'APO_MIGRATION_VIEWS_DIR' ) ) {
			define( 'APO_MIGRATION_VIEWS_DIR', plugin_dir_path( __DIR__ ) . 'src/views/' );
		}

		// JavaScript Folder URL
		if ( ! defined( 'APO_MIGRATION_JS_URL' ) ) {
			define( 'APO_MIGRATION_JS_URL', plugin_dir_url( __DIR__ ) . 'src/assets/js/' );
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
