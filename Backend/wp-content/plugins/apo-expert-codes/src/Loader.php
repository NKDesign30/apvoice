<?php

namespace apo\expertcodes;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader
{
	public function loadPluginFunctions()
	{
		require_once APO_EXPERT_CODES_FUNC_DIR . 'expertcodes-functions.php';
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