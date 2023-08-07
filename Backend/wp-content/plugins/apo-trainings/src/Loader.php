<?php

namespace apo\trng;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	public function loadPluginFunctions() 
	{
		require_once TRNG_FUNC_DIR . 'trng-functions.php';
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