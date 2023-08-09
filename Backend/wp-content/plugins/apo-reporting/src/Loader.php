<?php

namespace apo\reporting;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	/**
	* initialized all plugin styles and scripts
	*/
	public function initScripts() 
	{
		/* 
		wp_enqueue_style( APO_REPORTING_SLUG . 'style', APO_REPORTING_CSS_URL . APO_REPORTING_SLUG . 'style.css?v=' . APO_REPORTING_VERSION);
		wp_enqueue_script(APO_REPORTING_SLUG . 'script', APO_REPORTING_JS_URL . APO_REPORTING_SLUG . 'script.min.js?v=' . APO_REPORTING_VERSION, array('jquery'), '', true); 
		*/
	}

	/**
	 * initialized all plugin styles and scripts for the WordPress Backend
	 */
	public function initBackendScripts() 
	{
		/*
		wp_enqueue_script( APO_REPORTING_SLUG . 'backend', APO_REPORTING_JS_URL . APO_REPORTING_SLUG . 'backend.min.js?v=' . APO_REPORTING_VERSION, array('jquery'), '', true);
		*/
	}

	public function loadPluginFunctions() 
	{
		require_once APO_REPORTING_FUNC_DIR . 'apo_reporting-functions.php';
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