<?php

namespace raffle;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	/**
	* initialized all plugin styles and scripts
	*/
	public function initScripts() 
	{
		/* 
		wp_enqueue_style( RAFFLE_SLUG . 'style', RAFFLE_CSS_URL . RAFFLE_SLUG . 'style.css?v=' . RAFFLE_VERSION);
		wp_enqueue_script(RAFFLE_SLUG . 'script', RAFFLE_JS_URL . RAFFLE_SLUG . 'script.min.js?v=' . RAFFLE_VERSION, array('jquery'), '', true); 
		*/
	}

	/**
	 * initialized all plugin styles and scripts for the WordPress Backend
	 */
	public function initBackendScripts() 
	{
		/*
		wp_enqueue_script( RAFFLE_SLUG . 'backend', RAFFLE_JS_URL . RAFFLE_SLUG . 'backend.min.js?v=' . RAFFLE_VERSION, array('jquery'), '', true);
		*/
	}

	public function loadPluginFunctions() 
	{
		require_once RAFFLE_FUNC_DIR . 'raffle-functions.php';
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