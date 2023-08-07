<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\AzureUploader;
use Exception;
use \WP_Error;

class MediaController extends Controller
{
	public function __construct()
	{
        parent::__construct();
    }

    public function process( Request $request )
    {
        $azure = new AzureUploader();
        //$azure->toContainer(MICROSOFT_AZURE_RAFFLE_CONTAINER);
        $url = $azure->getBlobUrl($request['p']);
        if($url == null){
            return  new WP_Error(
                        'file_not_found',
                        'file_not_found',
                        array( 'status' => 404 )
            );
        }

        $image = $this->curl_get_contents($url);
        //print_r($image);
        //die();
        
        header("Cache-Control: private, max-age=10800, pre-check=10800");
        header("Pragma: private");
        header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
        header("Content-type: ".$image['mime']);
        header("Content-Disposition: inline; filename=\"".basename($url)."\"");
        echo $image['data'];
    }

    function curl_get_contents($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        return ["data" => $data, "mime" => $mime];
    }

    protected function getOrigins()
    {
        return implode(' ', $this->allowedOrigins);
    }
}
