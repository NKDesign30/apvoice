<?php

namespace knwldg;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	/**
	* initialized all plugin styles and scripts
	*/
	public function initScripts() 
	{
		/* 
		wp_enqueue_style( KNWLDG_SLUG . 'style', KNWLDG_CSS_URL . KNWLDG_SLUG . 'style.css?v=' . KNWLDG_VERSION);
		wp_enqueue_script(KNWLDG_SLUG . 'script', KNWLDG_JS_URL . KNWLDG_SLUG . 'script.min.js?v=' . KNWLDG_VERSION, array('jquery'), '', true); 
		*/
	}

	/**
	 * initialized all plugin styles and scripts for the WordPress Backend
	 */
	public function initBackendScripts() 
	{
		/*
		wp_enqueue_script( KNWLDG_SLUG . 'backend', KNWLDG_JS_URL . KNWLDG_SLUG . 'backend.min.js?v=' . KNWLDG_VERSION, array('jquery'), '', true);
		*/
	}

	public function loadPluginFunctions() 
	{
		require_once KNWLDG_FUNC_DIR . 'knwldg-functions.php';
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