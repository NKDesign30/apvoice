<?php

namespace apo\rxts;
use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	public function loadPluginFunctions() 
	{
		require_once RXTS_FUNC_DIR . 'rxts-functions.php';
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