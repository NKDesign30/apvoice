<?php

namespace awsm\wp\libraries;

use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\ResponseUtils;

class Controller {

    use ResponseUtils;

	public $db;
    public $urlParam;
	protected $model;
	protected $viewDirectory;
	protected $adminViewDirectory;
	protected $componentViewDirectory;

	public function __construct() 
	{
		$this->db = DB::instance();
        $this->urlParam = isset($_GET["site"]) ? $_GET['site'] : null;
        $this->model = null;
        $this->viewDirectory = null;
        $this->adminViewDirectory = null;
        $this->componentViewDirectory = null;
	}

	public function view($template, $data = array()) {
		$this->lock_template( $this->viewDirectory, $template, $data );
	}

	public function adminView($template, $data = array()) {
		$this->lock_template( $this->adminViewDirectory, $template, $data );
	}

	public function component($template, $data = array()) {
		$this->lock_template( $this->componentViewDirectory, $template, $data );
	}

	public function getTemplate($class)
	{
		$param = $this->getUrlParam();

		if(method_exists( $class, $param ) ) {
			$class->$param();
		} else {
			$this->couldnt_found_template();
		}
	}

	public function lock_template( $dir, $template, $data = array() )  
	{
		if( file_exists( $dir . $template . ".php" ) ) {
			include $dir . $template . ".php";
		} else {
			$this->couldnt_found_template();
		}
	}

	public function getUrlParam() 
	{
		if( !isset($this->urlParam) ) {
			$this->urlParam = 'admin';
		} 
		return $this->urlParam;
	}

	public function loadMethodByUrlParam($class)
	{
		$method = $this->createMethodName();
		if (method_exists($class, $method)) {
			$class->$method();
		} else {
			die('Method does not exist');
		}
	}

	private function couldnt_found_template() {
		die('View does not exist');
	}

	private function createMethodName()
	{
		$method = $this->getUrlParam();
		$method = preg_split('/[-_]/', $method);
		$method = array_map(function ($m) {
			return ucwords($m);
		}, $method);
		$method[0] = strtolower($method[0]);
		return implode('', $method);
	}

}