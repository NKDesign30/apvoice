<?php

namespace apo\bonago;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader
{
	public function loadPluginFunctions()
	{
		require_once APO_BONAGO_FUNC_DIR . 'apo-bonago-functions.php';
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