<?php

namespace apo\apopoints;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	/**
	* initialized all plugin styles and scripts
	*/
	public function initScripts() 
	{
		/* 
		wp_enqueue_style( APO_EXPERTPOINTS_SLUG . 'style', APO_EXPERTPOINTS_CSS_URL . APO_EXPERTPOINTS_SLUG . 'style.css?v=' . APO_EXPERTPOINTS_VERSION);
		wp_enqueue_script(APO_EXPERTPOINTS_SLUG . 'script', APO_EXPERTPOINTS_JS_URL . APO_EXPERTPOINTS_SLUG . 'script.min.js?v=' . APO_EXPERTPOINTS_VERSION, array('jquery'), '', true); 
		*/
	}

	/**
	 * initialized all plugin styles and scripts for the WordPress Backend
	 */
	public function initBackendScripts() 
	{
		/*
		wp_enqueue_script( APO_EXPERTPOINTS_SLUG . 'backend', APO_EXPERTPOINTS_JS_URL . APO_EXPERTPOINTS_SLUG . 'backend.min.js?v=' . APO_EXPERTPOINTS_VERSION, array('jquery'), '', true);
		*/
	}

	public function loadPluginFunctions() 
	{
		require_once APO_APOPOINTS_FUNC_DIR . 'apo_apopoints-functions.php';
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