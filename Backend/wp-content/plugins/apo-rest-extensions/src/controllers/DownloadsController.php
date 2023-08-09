<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;

class DownloadsController extends Controller
{

    protected $allowedMimeTypes = [
        'application/pdf',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', // .pptx
        'application/vnd.ms-powerpoint', // .ppt, .pot, .pps, .ppa
        'application/vnd.openxmlformats-officedocument.presentationml.template', // .potx
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow', // .ppsx
    ];

    /**
     * @todo
     * Add right origins
    */
    private $allowedOrigins = [
        '*'
    ];

	public function __construct()
	{
        parent::__construct();
    }
    
    public function register( Request $request )
    {
        $post = get_post($request['id']);
        if($post !== null){
            $count = get_field('downloads', $post->ID);
            update_field('downloads', $count+1, $post->ID);
            return true;
        }
        return false;
    }
    
    public function bundle( Request $request )
    {

        $values = $_GET['values'];
        $values = explode(",", base64_decode($values));
        //print_r($post);

        $zip = new \ZipArchive;
        # create a temp file & open it
        if(!is_dir(get_template_directory()."/temp")){
        mkdir(get_template_directory()."/temp");
        }
        $tmp_file = tempnam(get_template_directory()."/temp",'');
        $name_arr = Array();
        if ($zip->open($tmp_file, \ZipArchive::CREATE) === TRUE) {
            //$zip->addFile($post["url"], "test.png");
            foreach($values AS $id){
                $post = get_field("file", $id);
                # download file
                $download_file = file_get_contents($post["url"]);
                if($download_file !== false){
                    #add it to the zip
                    if(!isset($name_arr[basename($post["url"])])){
                        $name_arr[] = Array(basename($post["url"]) => 1);
                        $name = basename($post["url"]);
                    }else{
                        $name_arr[basename($post["url"])] = $name_arr[basename($post["url"])] + 1;
                        $name = basename($post["url"]) . " (".$name_arr[basename($post["url"])].")";
                    }
                    $zip->addFromString($name, $download_file);
                }
            }
            $zip->close();
        } else {
            echo 'Fehler';
        }

        # send the file to the browser as a download
        header('Content-disposition: attachment; filename=downloads.zip');
        header('Content-type: application/zip');
        readfile($tmp_file);
        die();
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

        if(!in_array($attachment->post_mime_type, $this->allowedMimeTypes)) {
            return new \WP_Error( __('forbidden_mime_type', 'rxts'), __('Your request does not match the criteria', 'rxts'), array( 'status' => 403 ) );
        }

        $file_path = get_attached_file( $attachment->ID );

        $extension = explode('/', $attachment->post_mime_type )[1];
        $filename = $attachment->post_name . $extension;

        header( $_SERVER['SERVER_PROTOCOL'] .' 200 OK', true );
        header( 'Access-Control-Allow-Origin:' . $this->getOrigins() );
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
