<?php

namespace awsm\wp\libraries\middleware;

use awsm\wp\libraries\utilities\RoutesCollector;

class ApiRoutesMiddleware
{

    protected $routesCollector;

    protected $routes;

    protected $ignored = [
        '^\/apovoice\/v1\/static\/\d+$',
        '^\/apovoice\/v1\/pharmacies\/.+$',
        '^\/apovoice\/v1\/sales-reps\/expert-code\/.+$',
        '^\/gf\/v2\/forms\/(?P<form_id>[\d]+)\/submissions',
        '^\/gf\/v2\/forms\/(?P<form_id>[\d]+)',
        '^\/wp\/v2\/pages',
        '^\/wp\/v2\/pages.+$'
    ];

    public function __construct()
    {
        $this->routesCollector = RoutesCollector::instance();
    }

    protected function setRoutesByMethod($method)
    {
        if(array_key_exists($method, $this->getCollectorRoutes())) {
            $this->routes = $this->getCollectorRoutes($method);
        } else {
            $this->routes = $this->getCollectorRoutes(RoutesCollector::RAW_ROUTES);
        }

        return $this;
    }

    protected function getCollectorRoutes($type = null)
    {
		return $this->routesCollector->getRoutes($type);
    }

    protected function getRoutes($type = null)
    {
        if(!is_null($type)) {
			return $this->routes[$type];
		}
        return $this->routes;
    }

    protected function isPublic($route)
    {
        return in_array($route, $this->getRoutes(RoutesCollector::PUBLIC_ROUTES));
    }

    protected function isOptionsRequest($method)
    {
        return mb_strtoupper($method) === RoutesCollector::OPTIONS_REQUEST;
    }

    protected function isIgnored($route)
    {
        foreach ($this->ignored as $ignored) {
            if (preg_match('/' . $ignored . '/', $route) === 1) {
                return true;
            }
        }

        return false;
    }

    protected function unauthorizedRequest()
    {
        return new \WP_Error(
            "unauthorized",
            "You are unauthorized, please sign in",
            array( "status" => 401 )
        );
    }

}