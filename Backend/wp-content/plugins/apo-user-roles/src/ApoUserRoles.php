<?php

namespace apo\userroles;

use apo\userroles\Loader;

class ApoUserRoles {

	private static $instance;
	private $loader;

	/**
	* @return self
	*/
	public static function instance() 
	{
		if( !self::$instance  && !self::$instance instanceof ApoUserRoles) {
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
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'apo_user_roles', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'APO_USER_ROLES_VERSION' ) ) {
			define( 'APO_USER_ROLES_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'APO_USER_ROLES_SLUG' ) ) {
			define( 'APO_USER_ROLES_SLUG', 'apo_userroles_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'APO_USER_ROLES_PLUGIN_DIR' ) ) {
			define( 'APO_USER_ROLES_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'APO_USER_ROLES_PLUGIN_URL' ) ) {
			define( 'APO_USER_ROLES_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'APO_USER_ROLES_FUNC_DIR' ) ) {
			define( 'APO_USER_ROLES_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
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
