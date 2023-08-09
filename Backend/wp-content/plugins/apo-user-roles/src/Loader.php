<?php

namespace apo\userroles;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	public function loadPluginFunctions() 
	{
		require_once APO_USER_ROLES_FUNC_DIR . 'apo-user-roles-functions.php';
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