<?php

namespace apo\pun;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader
{
	public function loadPluginFunctions()
	{
		require_once APO_PUN_FUNC_DIR . 'pun-functions.php';
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