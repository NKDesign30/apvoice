<?php

namespace apo\pgci;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader
{
	public function loadPluginFunctions()
	{
		require_once APO_PGCI_FUNC_DIR . 'pgci-functions.php';
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