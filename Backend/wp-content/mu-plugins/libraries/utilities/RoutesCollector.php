<?php

namespace awsm\wp\libraries\utilities;

class RoutesCollector 
{

    private static $instance;
	public $routes;
	public $methods;
	
	const ROUTE_NAMESPACES = 'route_namespaces';
	const PUBLIC_ROUTES = 'public';
	const PROTECTED_ROUTES = 'protected';
	const ADMIN_ROUTES = 'admin';

	const GET_REQUEST = 'GET';
	const POST_REQUEST = 'POST';
	const PATCH_REQUEST = 'PATCH';
	const PUT_REQUEST = 'PUT';
	const DELETE_REQUEST = 'DELETE';
	const OPTIONS_REQUEST = 'OPTIONS';

	const METHODS = [
		self::GET_REQUEST,
		self::POST_REQUEST,
		self::PATCH_REQUEST,
		self::PUT_REQUEST,
		self::DELETE_REQUEST,
	];

	const RAW_ROUTES = 'RAW';

	/**
	 * @return self
	 */
	public static function instance()
	{
		if (!self::$instance && !self::$instance instanceof RoutesCollector) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	private function __construct() 
	{
        $this->routes = [];
	}

	/**
	 * @param string|array $routes 
	 * @param string $type
	 * @param array $methods http verbs
	 * 
	 * @return awsm\wp\libraries\utilities\RoutesCollector 
	 */
	public function collect($routes, $type = self::PROTECTED_ROUTES, array $methods = self::METHODS)
    {

		foreach ($methods as $method) {
			$this->storeRoutes($routes, mb_strtoupper($method), $type);
		}

		$this->storeRoutesRaw($routes, $type);

        return $this;
	}
	
	/**
	 * @param string|array $routes 
	 * @param array $methods http verbs
	 * 
	 * @return awsm\wp\libraries\utilities\RoutesCollector 
	 */
	public function collectRouteNamespace($routes, array $methods = [])
	{
		if(!$methods) {
			$this->collect($routes, self::ROUTE_NAMESPACES);
		}
		$this->collect($routes, self::ROUTE_NAMESPACES, $methods);
		return $this;
	}

	/**
	 * @param string|array $routes 
	 * @param array $methods http verbs
	 * 
	 * @return awsm\wp\libraries\utilities\RoutesCollector 
	 */
	public function collectPublicRoute($routes, array $methods = [])
	{
		if(!$methods) {
			$this->collect($routes, self::PUBLIC_ROUTES);
		}
		$this->collect($routes, self::PUBLIC_ROUTES, $methods);
	}

	/**
	 * @param string|array $routes 
	 * @param array $methods http verbs
	 * 
	 * @return awsm\wp\libraries\utilities\RoutesCollector 
	 */
	public function collectProtectedRoute($routes, array $methods = [])
	{
		if(!$methods) {
			$this->collect($routes, self::PROTECTED_ROUTES);
		}
		$this->collect($routes, self::PROTECTED_ROUTES, $methods);
	}

	/**
	 * @param string|array $routes 
	 * @param array $methods http verbs
	 * 
	 * @return awsm\wp\libraries\utilities\RoutesCollector 
	 */
	public function collectAdminRoute($routes, array $methods = [])
	{
		if(!$methods) {
			$this->collect($routes, self::ADMIN_ROUTES);
		}
		$this->collect($routes, self::ADMIN_ROUTES, $methods);
	}

    public function getRoutes($type = null)
    {
		if(!is_null($type)) {
			return $this->routes[$type];
		}
        return $this->routes;
	}

	private function addRoute($route, $method, $type)
	{
		if(!awsm_strings_starts_with($route, '/')) {
			$route = '/' . $route;
		}
		$this->routes[$method][$type][] = $route;
		return $this;
	}

	private function storeRoutes($routes, $method, $type)
	{
		if(is_array($routes)) {
			foreach ($routes as $route) {
				$this->addRoute($route, $method, $type);
			}
		} else {
			$this->addRoute($routes, $method, $type);
		}
		return $this;
	}

	private function storeRoutesRaw($routes, $type)
	{
		$this->storeRoutes($routes, self::RAW_ROUTES, $type);
		return $this;
	}

}