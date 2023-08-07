<?php

namespace apo\detailersjob;

use apo\detailersjob\Loader;
use apo\detailersjob\rest\Routes;
use apo\detailersjob\rest\InformationalTrainingRestFields;
use apo\detailersjob\cpt\InformationalTraining as InformationalTrainingCustomPostType;

class ApoDetailersJob
{
	private static $instance;
	private $loader;
	private $informationalTrainingRestFields;

	/**
	* @return self
	*/
	public static function instance()
	{
		if( !self::$instance  && !self::$instance instanceof ApoDetailersJob) {
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
		$this->informationalTrainingRestFields = new InformationalTrainingRestFields();
	}

	private function defineHooks()
	{
        // init scripts & styles
		$this->loader->add_action('init', new InformationalTrainingCustomPostType, 'register');
		$this->loader->add_action('init', $this, 'loadTextdomain');
		$this->loader->add_action('rest_api_init', $this->routes, 'register');
		$this->loader->add_action('rest_api_init', $this->informationalTrainingRestFields, 'register');
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain( 'apovoice-detailers-job', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
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
		if ( ! defined( 'DETAILERS_JOB_VERSION' ) ) {
			define( 'DETAILERS_JOB_VERSION', '1.0.0' );
		}

		// Plugin Slug
		if ( ! defined( 'DETAILERS_JOB_SLUG' ) ) {
			define( 'DETAILERS_JOB_SLUG', 'detailersjob_' );
		}

		// Plugin Folder Path
		if ( ! defined( 'DETAILERS_JOB_PLUGIN_DIR' ) ) {
			define( 'DETAILERS_JOB_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'DETAILERS_JOB_PLUGIN_URL' ) ) {
			define( 'DETAILERS_JOB_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}

		// Plugin Functions Folder Path
		if ( ! defined( 'DETAILERS_JOB_FUNC_DIR' ) ) {
			define( 'DETAILERS_JOB_FUNC_DIR', plugin_dir_path( __DIR__ ) . 'src/plugin-functions/');
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
