<?php

namespace apo\svy;
use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	/**
	* initialized all plugin styles and scripts
	*/
	public function initScripts() 
	{
		/* 
		wp_enqueue_style( SVY_SLUG . 'style', SVY_CSS_URL . SVY_SLUG . 'style.css?v=' . SVY_VERSION);
		wp_enqueue_script(SVY_SLUG . 'script', SVY_JS_URL . SVY_SLUG . 'script.min.js?v=' . SVY_VERSION, array('jquery'), '', true); 
		*/
	}

	/**
	 * initialized all plugin styles and scripts for the WordPress Backend
	 */
	public function initBackendScripts() 
	{
		/*
		wp_enqueue_script( SVY_SLUG . 'backend', SVY_JS_URL . SVY_SLUG . 'backend.min.js?v=' . SVY_VERSION, array('jquery'), '', true);
		*/
	}

	/**
	 * initialized ajax scripts
	 */
	public function initAjaxScripts() 
	{
		/*
	 	wp_enqueue_script( SVY_SLUG . 'ajax', SVY_JS_URL . SVY_SLUG . 'ajax.min.js', array('jquery'), '', false);

	 	wp_localize_script( SVY_SLUG . 'ajax', 'YOUR_UNIQUE_AJAX_KEY', array(
    		'ajaxurl' => admin_url( 'admin-ajax.php' ),
    		'your_custom_data' => 'send this data with a ajax request',
    		)
		);
		*/
	}

	public function loadPluginFunctions() 
	{
		require_once SVY_FUNC_DIR . 'svy-functions.php';
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