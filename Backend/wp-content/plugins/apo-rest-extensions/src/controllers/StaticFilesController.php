<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;

class StaticFilesController extends Controller
{
	public function __construct()
	{
        parent::__construct();
	}

    public function process( Request $request )
    {
        $attachment = get_post($request['id']);

        if(!$attachment) {
            return new \WP_Error( __('attachment_does_not_exist', 'rxts'), __('The attachment you are looking for does not exist', 'rxts'), array( 'status' => 404 ) );
        }

        if($attachment->post_type !== 'attachment') {
            return new \WP_Error( __('forbidden_post_type', 'rxts'), __('Your request does not match the criteria', 'rxts'), array( 'status' => 403 ) );
        }

        $file_path = get_attached_file( $attachment->ID );

        $extension = explode('/', $attachment->post_mime_type )[1];
        $filename = $attachment->post_name . $extension;

        header( $_SERVER['SERVER_PROTOCOL'] .' 200 OK', true );
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Cache-Control: public', true );
        header( 'Content-Type: ' . $attachment->post_mime_type, true );
        header( 'Content-Transfer-Encoding: Binary', true );
        header( 'Content-Length:' . filesize( $file_path ), true );
        header( 'Content-Disposition: attachment; filename=' . $filename, true );
        readfile( $file_path );
        exit;
    }

    protected function getOrigins()
    {
        return implode(' ', $this->allowedOrigins);
    }
}
