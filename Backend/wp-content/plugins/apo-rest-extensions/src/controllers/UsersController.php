<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;

// include GF User Registration functionality
require_once( gf_user_registration()->get_base_path() . '/includes/signups.php' );

class UsersController extends Controller
{
	public function __construct()
	{
        parent::__construct();
	}

    public function activate( Request $request )
    {
        \GFUserSignups::prep_signups_functionality();

        return [
            'result' => \GFUserSignups::activate_signup( $request->get_param( 'key' ) ),
        ];
    }

    public function newsletterState( $object )
    {
        $user = get_userdata( get_current_user_id() );
        $newsletter = maybe_unserialize( get_user_meta( $user->ID, 'accepted_newsletter', true) );
        $registerdate = strtotime($user->data->user_registered);

        if($newsletter == 'data_protection_regulations' || $registerdate < strtotime( "2020-10-09 00:00:00" )){
            return true;
        }
        
        return false;
    }

    public function acceptNewsletter( Request $request )
    {
        $user = new \WP_User( get_current_user_id() );

        if ( ! in_array( "accepted_newsletter", $user->roles ) )
            $user->add_role( "accepted_newsletter" );

        add_user_meta($user->ID, "accepted_newsletter", "data_protection_regulations", true);

        return;
    }

    public function confirmmail( Request $request )
    {
        global $wpdb;

        $user_activation_key = base64_decode($request->get_param( 'key' ));

        if( empty($user_activation_key) === true ) {
            return ['result' => new \WP_Error( 'no_confirmation_key', __( 'The confirmation key is required.' ), 'apovoice' ) ];
        }

        $query = $wpdb->prepare( "
        SELECT
            `id`
        FROM
            `{$wpdb->users}`
        WHERE
            `user_activation_key` = %s
    ", array( trim( $user_activation_key ) ) );

        $user_id = $wpdb->get_var( $query );

        if( !$user_id ){
            return ['result' => new \WP_Error( 'confirmation_key_invalid', __( 'The confirmation key is invalid. Please make sure you copied the whole URL to your browsers address bar.' ), 'apovoice' )];
        }

        $key_parts = explode(':', $user_activation_key);
        list( $timestamp, $hash ) = $key_parts;

        if($timestamp + 172800 <= time()){
            return ['result' => new \WP_Error( 'confirmation_key_expired', __( 'Your confirmation key is expired. Please go to your profile and try again.' ), 'apovoice' ) ];
        }

        $new_mail = get_user_meta($user_id, 'tmp_new_email');

        if(email_exists($new_mail[0])){
            return ['result' => new \WP_Error( 'new_mail_exists', __( 'The desired email address already exists.' ), 'apovoice' )];
        }


        if( empty($new_mail) === false ) {
            wp_update_user( [
                'ID' => $user_id,
                'user_email' => $new_mail[0],
            ] );
        }


        return [
            'user_id' => $user_id,
            'user_mail' => $new_mail[0],
            'result' => true,
        ];
    }
}
