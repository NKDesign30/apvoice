<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\CertificateController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Certificate extends WP_REST_Controller implements RegisterableInterface
{

    use Auth;
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {

    }

    public function register()
    {
        $this->registerCertificateRoute();
    }

    public function registerCertificateRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/certificate/(?P<training>[\d]+)/(?P<year>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new CertificateController, 'index' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }
}
