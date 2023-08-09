<?php 

namespace apo\rxts\policies;

use \WP_Error;
use apo\rxts\metaboxes\UserAccessPermissions;
use \WP_REST_Request;
use \WP_HTTP_Response;

class ResponsePolicy
{

    /**
    * @link https://developer.wordpress.org/reference/hooks/rest_request_after_callbacks/
    */
    public function protect( $response, array $handler, WP_REST_Request $request )
    {
        if($response instanceof WP_HTTP_Response && !$this->isFrontPage($request->get_route())) {
            $responseData = $response->get_data();
            if( in_array($responseData['type'], UserAccessPermissions::POST_TYPES) ) {

                if( !UserAccessPermissions::canAccess($responseData['id']) ) {
                    return $this->forbiddenAccess();
                }

            }
        }
        return $response;
    }

    protected function forbiddenAccess()
    {
        return new WP_Error( 
            "forbidden_access", 
            "You don't have permissions to access this resource", 
            array( "status" => 403 ) 
        );
    }

    private function isFrontPage($route)
    {
        if (strpos( strtolower($route), '/frontpage') !== false) {
            return true;
        }
        return false;
    }
}