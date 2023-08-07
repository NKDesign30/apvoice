<?php

namespace apo\detailersjob;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	public function loadPluginFunctions()
	{
		require_once DETAILERS_JOB_FUNC_DIR . 'detailers-job-functions.php';
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
