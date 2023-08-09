<?php

namespace apo\fuzzysearch;

use awsm\wp\libraries\Loader as BaseLoader;

class Loader extends BaseLoader {

	public function loadPluginFunctions() 
	{
		require_once APO_FUZZY_SEARCH_FUNC_DIR . 'apo-fuzzy-search-functions.php';
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
