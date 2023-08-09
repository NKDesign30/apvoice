<?php

namespace raffle\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use raffle\models\Raffle;
use apo\rxts\utilities\AzureRaffleUploader;

class RaffleController extends Controller
{
  use Auth;

	public function __construct()
	{
        parent::__construct();
        $this->model = new Raffle();
	}

	public function index( Request $request )
  {
     $result = $this->model->show();
     return $this->prepareResponse($result);
  }

  public function store( Request $request )
  {
      $data = array_merge($request->get_params(), ['user_id' => $this->userId()]);
      
      if(array_key_exists('contest', $_FILES)){
        $uploaded = $this->uploadRafflePicture($data);

        if(!$uploaded)
          return json_encode(array('state' => false, 'message' => 'could not upload the file: wrong format'));
      }

      $result = $this->model->create($data);
      return $result;
  }

  public function show( Request $request )
  {
     $result = $this->model->showOne($request->get_param('id'));
     return $this->prepareResponse($result);
  }

  protected function uploadRafflePicture(&$data) {
      $azureRaffleUploader = new AzureRaffleUploader();
      $user_id = get_current_user_id();
      $file = $_FILES['contest'];
      $raffle_uploads_dir = realpath( wp_upload_dir()['basedir'] . '/../user-uploads/raffle-uploads' );
      $hash = sha1( get_current_user_id() . time() . mt_rand() );



      if($file["type"] == "application/pdf"){
        $file_name = $hash . '.pdf';
      }else{
        $image_info = getimagesize( $file['tmp_name'] );
        preg_match( '/^image\/(jpe?g|png|gif|bmp)$/i', $image_info['mime'], $matches );
        $file_name = $hash . "." . $matches[1];

        $image_resource = null;
        switch ( $matches[1] ) {
            case 'jpeg':
            case 'jpg':
                $image_resource = imagecreatefromjpeg( $file['tmp_name'] );

                break;

            case 'png':
                $image_resource = imagecreatefrompng( $file['tmp_name'] );

                break;

            case 'gif':
                $image_resource = imagecreatefromgif( $file['tmp_name'] );

                break;

            case 'bmp':
                $image_resource = imagecreatefrombmp( $file['tmp_name'] );

                break;
        }

        if ( is_null( $image_resource ) ) {
            imagedestroy( $image_resource );

            return false;
        }

        $image_stored = imagejpeg( $image_resource );

        imagedestroy( $image_resource );

        if ( $image_stored === false ) {
            return false;
        }
      }
      $azureRaffleUploader->upload($file['tmp_name'], $file_name);
      unlink( "{$raffle_uploads_dir}/{$file_name}" );

      $data['contest'] = $file_name;
      //update_user_meta( $user_id, 'profile_picture', $profile_pictures );

      return true;
  }
}
