<?php

namespace apo\rxts\rest;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Routes implements RegisterableInterface
{

    public function __construct()
    {

    }

    public function register()
    {
        $routes = [
            'apo\rxts\rest\routes\Menus',
            'apo\rxts\rest\routes\Pharmacies',
            'apo\rxts\rest\routes\Users',
            'apo\rxts\rest\routes\Settings',
            'apo\rxts\rest\routes\Downloads',
            'apo\rxts\rest\routes\Media',
            'apo\rxts\rest\routes\TrainingQuestions',
            'apo\rxts\rest\routes\StaticFiles',
            'apo\rxts\rest\routes\PagePermissions',
            'apo\rxts\rest\routes\JWT',
            'apo\rxts\rest\routes\SalesReps',
            'apo\rxts\rest\routes\Certificate',
            'apo\rxts\rest\routes\ConfirmPharmacy',
        ];

        foreach ($routes as $route) {
            $routeObject = new $route();
            $routeObject->register();
        }
    }
}
