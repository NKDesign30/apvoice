<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use apo\rxts\utilities\AzureProfileUploader;


class UserProfilesController extends Controller
{
	public function __construct()
	{
        parent::__construct();
	}

    public function update( Request $request )
    {
        $response_fields = [
            'changed_profile_picture' => false,
            'changed_email' => false,
            'changed_password' => false,
        ];

        $this->updateBasicFields( $request );
        $this->updateUserFields( $request );
        $this->updateAssociatedPharmacies( $request );

        if ( $this->shouldUpdateNewEmail( $request ) ) {
            $this->confirmNewEmail( $request );
        }

        if ( $this->shouldUpdateEmail( $request ) && !$this->shouldUpdateNewEmail( $request ) ) {
            $response_fields['changed_email'] = $this->updateEmail( $request );
        }

        if ( $this->shouldUpdatePassword( $request ) ) {
            $response_fields['changed_password'] = $this->updatePassword( $request );
        }

        if ( $this->shouldUpdateProfilePicture() ) {
            $response_fields['changed_profile_picture'] = $this->updateProfilePicture();
        }

        return $response_fields;
    }

    protected function updateBasicFields( Request $request ) {
        $user_id = get_current_user_id();
        $fields = [
            'form_of_address', 'title', 'job',
            'working_since', 'age', 'tasks', 'expert_only_pharmacies',
        ];

        foreach ( $fields as $field ) {
            update_user_meta( $user_id, $field, $request->get_param( $field ) );
        }

        $priorities = $request->get_param( 'priorities' );
        $other_priorities = $request->get_param( 'other_priorities' );

        if ( ! empty( $other_priorities ) ) {
            $priorities[] = $other_priorities;
        }

        update_user_meta( $user_id, 'priorities', $priorities );
    }

    protected function updateAssociatedPharmacies( Request $request ) {
        global $wpdb;

        $user_id = get_current_user_id();
        $associated_pharmacies = $request->get_param( 'associated_pharmacies' );

        $pharmacy_unique_numbers = array_map( function ( $pun ) use ( $wpdb ) {
            return $wpdb->prepare( '%s', $pun );
        }, $associated_pharmacies );

        $sql = "
            SELECT
                `id`
            FROM
                `{$wpdb->prefix}apovoice_pharmacies`
            WHERE
                `pharmacy_unique_number` IN (
                    " . implode( ', ', $pharmacy_unique_numbers ) . "
                )
        ";

        $pharmacy_ids = $wpdb->get_col( $sql );

        $sql = $wpdb->prepare( "
            DELETE FROM
                `{$wpdb->prefix}apovoice_pharmacy_user`
            WHERE
                `user_id` = %d
        ", array( $user_id ) );

        $wpdb->query( $sql );

        $values = array_map( function ( $pharmacy_id ) use ( $wpdb, $user_id ) {
            return $wpdb->prepare( '(%s, %s)', [ $pharmacy_id, $user_id ] );
        }, $pharmacy_ids );

        $sql = "
            INSERT INTO
                `{$wpdb->prefix}apovoice_pharmacy_user`
                (
                    `pharmacy_id`,
                    `user_id`
                )
            VALUES
        " . implode( ', ', $values );

        $wpdb->query( $sql );
    }

    protected function updateUserFields( Request $request ) {
        wp_update_user( [
            'ID' => get_current_user_id(),
            'user_nicename' => $request->get_param( 'first_name' ),
            'display_name' => $request->get_param( 'first_name' ),
            'nickname' => $request->get_param( 'first_name' ),
            'first_name' => $request->get_param( 'first_name' ),
            'last_name' => $request->get_param( 'last_name' ),
        ] );
    }

    protected function confirmNewEmail( Request $request ) {
        if( $request->get_param('account_email') === $request->get_param('account_new_email') ){
            return true;
        }

        global $wpdb;

        $user_data = get_user_by( 'email', $request->get_param('account_email') );
//        $user_login = $user_data->user_login;

        $key = wp_generate_password( 20, false );
        $hashed_key = time() . ':' . wp_hash_password( $key );

        wp_update_user( [
            'ID' => $user_data->ID,
            'user_activation_key' => $hashed_key,
        ] );

        update_user_meta($user_data->ID, 'tmp_new_email', $request->get_param('account_new_email'));

        $form_id = get_option( 'apo_change_email_form' );

        $entry = array(
            "form_id" => $form_id,
            "1" => $request->get_param('account_new_email'),
            "2" => $request->get_param('account_email'),
        );

        $entry_id = \GFAPI::add_entry($entry);

        $form = \GFAPI::get_form($form_id);
        $entry = \GFAPI::get_entry($entry_id);

        \GFAPI::send_notifications( $form, $entry, 'form_submission');
    }

    protected function shouldUpdateNewEmail( Request $request ) {
        return $request->get_param('account_new_email') != '';
    }

    protected function shouldUpdateEmail( Request $request ) {
        return $request->get_param('account_email') != '';
    }

    protected function shouldUpdatePassword( Request $request ) {
        return $request->get_param('account_password') != '';
    }

    protected function shouldUpdateProfilePicture() {
        if ( ! isset( $_FILES ) || ! is_array( $_FILES ) || empty( $_FILES ) ) {
            return false;
        }

        if ( ! isset( $_FILES['profile_picture'] ) || ! is_array( $_FILES['profile_picture'] ) || empty( $_FILES['profile_picture'] ) ) {
            return false;
        }

        $image_info = getimagesize($_FILES['profile_picture']['tmp_name']);

        if ( $image_info === false ) {
            return false;
        }

        return preg_match( '/^image\/(?:jpe?g|png|gif|bmp)$/i', $image_info['mime'] ) !== false;
    }

    protected function updateEmail( Request $request ) {
        $user_id = get_current_user_id();

        return wp_update_user( [
            'ID' => $user_id,
            'user_email' => $request->get_param( 'account_email' ),
        ] ) == $user_id;
    }

    protected function updatePassword( Request $request ) {
        $user_id = get_current_user_id();

        return wp_update_user( [
            'ID' => $user_id,
            'user_pass' => $request->get_param( 'account_password' ),
        ] ) == $user_id;
    }

    protected function updateProfilePicture() {
        $azureProfileUploader = new AzureProfileUploader();
        $user_id = get_current_user_id();
        $file = $_FILES['profile_picture'];
        $profile_pictures_dir = realpath( wp_upload_dir()['basedir'] . '/../user-uploads/profile-pictures' );
        $image_info = getimagesize( $file['tmp_name'] );
        $hash = sha1( get_current_user_id() . time() . mt_rand() );
        
        preg_match( '/^image\/(jpe?g|png|gif|bmp)$/i', $image_info['mime'], $matches );
        
        $file_name = $hash . '.' . $matches[1];
        $target_path = "{$profile_pictures_dir}/{$file_name}";

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

        ob_start();
        imagejpeg( $image_resource );
        $image_stored = ob_get_contents();
        ob_end_clean();

        imagedestroy( $image_resource );

        if ( $image_stored === false ) {
            return false;
        }

        $profile_pictures = [$file_name];
        $profile_picture_sizes = [
        ];

        foreach ( $profile_picture_sizes as $size ) {
            [$width, $height] = $size;
            $image_editor = wp_get_image_editor( $image_stored );

            if ( is_wp_error( $image_editor ) ) {
                try {
                    unlink( $target_path );
                } catch ( \Exception $e ) {
                }

                return false;
            }

            $variant_name = "{$hash}-{$width}x{$height}.jpg";

            $image_editor->resize( $width, $height, ['center', 'center'] );
            $image_editor->save( "{$profile_pictures_dir}/{$variant_name}" );

            $azureProfileUploader->upload("{$profile_pictures_dir}/{$variant_name}", $variant_name);
            unlink( "{$profile_pictures_dir}/{$variant_name}" );

            $profile_pictures[] = $variant_name;
        }

        $previous_profile_pictures = maybe_unserialize( get_user_meta( $user_id, 'profile_picture', true ) );

        foreach ( $previous_profile_pictures as $previous_profile_picture ) {
            $previous_profile_picture_path = "{$profile_pictures_dir}/{$previous_profile_picture}";

            if ( file_exists( $previous_profile_picture_path ) && is_file( $previous_profile_picture_path ) ) {
                try {
                    unlink( $previous_profile_picture_path );
                } catch ( \Exception $e ) {
                }
            }

            if ( $azureProfileUploader->blobExists($previous_profile_picture) ) {
                $azureProfileUploader->destroy($previous_profile_picture);
            }
        }
        
        $azureProfileUploader->upload($file['tmp_name'], $file_name);
        unlink( "{$profile_pictures_dir}/{$file_name}" );
        
        update_user_meta( $user_id, 'profile_picture', $profile_pictures );

        return true;
    }
}
