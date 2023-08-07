<?php 

namespace knwldg\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use awsm\wp\libraries\interfaces\RegisterableInterface;
use knwldg\controllers\KnowledgeBaseController;

class KnowledgeBase extends WP_REST_Controller implements RegisterableInterface 
{

    use auth;

    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        $this->namespace = self::ROUTE_NAMESPACE;
        $this->rest_base = self::CURRENT_BASE;
    }

    public function register()
    {
        $this->registerKnowledgeBaseRoute();
        $this->registerKnowledgeBasePerIdRoute();
    }

    public function registerKnowledgeBaseRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/knowledge-base', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new KnowledgeBaseController, 'index' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }


    public function registerKnowledgeBasePerIdRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/knowledge-base/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new KnowledgeBaseController, 'show' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }
}
