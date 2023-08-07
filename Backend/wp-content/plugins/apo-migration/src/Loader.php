<?php

namespace apo\migration;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	/**
	* initialized all plugin styles and scripts
	*/
	public function initScripts() 
	{
		/* 
		wp_enqueue_style( APO_MIGRATION_SLUG . 'style', APO_MIGRATION_CSS_URL . APO_MIGRATION_SLUG . 'style.css?v=' . APO_MIGRATION_VERSION);
		wp_enqueue_script(APO_MIGRATION_SLUG . 'script', APO_MIGRATION_JS_URL . APO_MIGRATION_SLUG . 'script.min.js?v=' . APO_MIGRATION_VERSION, array('jquery'), '', true); 
		*/
	}

	/**
	 * initialized all plugin styles and scripts for the WordPress Backend
	 */
	public function initBackendScripts() 
	{
		
		wp_enqueue_script( APO_MIGRATION_SLUG . 'backend', APO_MIGRATION_JS_URL . APO_MIGRATION_SLUG . '_main.js?v=' . APO_MIGRATION_VERSION, array('jquery'), '', true);
		
	}

	public function loadPluginFunctions() 
	{
		require_once APO_MIGRATION_FUNC_DIR . 'apo_migration-functions.php';
	}

	/**
	 * initialized all action hooks and filters
	 */
	public function run() 
	{
		parent::run();

		$this->loadPluginFunctions();
	}

}