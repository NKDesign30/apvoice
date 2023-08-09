<?php

namespace dwnld;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	/**
	* initialized all plugin styles and scripts
	*/
	public function initScripts() 
	{
		/* 
		wp_enqueue_style( DWNLD_SLUG . 'style', DWNLD_CSS_URL . DWNLD_SLUG . 'style.css?v=' . DWNLD_VERSION);
		wp_enqueue_script(DWNLD_SLUG . 'script', DWNLD_JS_URL . DWNLD_SLUG . 'script.min.js?v=' . DWNLD_VERSION, array('jquery'), '', true); 
		*/
	}

	/**
	 * initialized all plugin styles and scripts for the WordPress Backend
	 */
	public function initBackendScripts() 
	{
		/*
		wp_enqueue_script( DWNLD_SLUG . 'backend', DWNLD_JS_URL . DWNLD_SLUG . 'backend.min.js?v=' . DWNLD_VERSION, array('jquery'), '', true);
		*/
	}

	public function loadPluginFunctions() 
	{
		require_once DWNLD_FUNC_DIR . 'dwnld-functions.php';
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