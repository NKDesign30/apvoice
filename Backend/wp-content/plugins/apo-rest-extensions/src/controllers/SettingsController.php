<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use \Datetime;

class SettingsController extends Controller
{

	public function __construct()
	{
        parent::__construct();
	}

    public function index( Request $request, $invitation_codes = null)
    {
        global $apo_form_locations;
        $user = wp_get_current_user();

        $formLocations = array_map(function($form) {
            return [
                'title' => $form['title'],
                'id' => get_option( $form['key'], null ),
                'key' => $form['key'],
            ];
        }, $apo_form_locations);

        $url = get_option( 'apo_frontend_url', null );

        $translation_array = array(
            // home page is home page not page title
            'is_front_page'		 => is_front_page(),
            'page_title'		 => $url,
        );

        $ga_options = prepare_ga_options_for_frontend();

        $id = $ga_options['tracking_id'];
        if (isset($id) && $id != "") {
            if (isset($ga_options['domain']) && $ga_options['domain'] != "") {
                $domain = $ga_options['domain'];
            } else {
                $domain = 'auto';
            }
            $ga_create_call = (isset($ga_options['anonymizeip']) && $ga_options['anonymizeip']) ? "ga('create','$id', '$domain', {anonymizeIp: true});" : "ga('create','$id', '$domain');";


            $script = 
            "<script>
                var ga_options = ".json_encode($ga_options).";
                var gaePlaceholders = ".json_encode($translation_array).";

                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
                ".$ga_create_call."
                ga('send', 'pageview');
            </script>";
        }
        

        return [
            'frontend_url' => $url,
            'form_locations' => $formLocations,
            'job_roles' => $this->jobRoles($request),
            'show_voucher' => $this->showVoucher($request),
            'newsletter_popover' => get_option( 'apo_newsletter_popover', '' ),
            'newsletter_privacy' => get_option( 'apo_newsletter_privacy', '' ),
            'head_code_snippets' => get_option( 'apo_head_code_snippets', '' ).$script,
            'body_code_snippets' => get_option( 'apo_body_code_snippets', '' ),
            'bonago_voucher_url' => get_option( 'apo_bonago_vouchers_url', null ),
            'captcha_website_key' => get_option( 'rg_gforms_captcha_public_key', '' ),
            'sites' => $this->sites($request),
            'invitation_codes' => $invitation_codes ? $invitation_codes : json_decode(get_user_meta( $user->ID, 'invitation_codes', true )),
        ];
    }

    public function sites( Request $request )
    {
        $results = Array();
        $sites = get_sites();
        foreach($sites AS $site){
            $results[] = Array(
                'url' => get_blog_option($site->blog_id, 'apo_frontend_url', '' ),
                'title' => get_blog_option($site->blog_id, 'blogname', '' ),
                'iso' => get_blog_option($site->blog_id, 'WPLANG', '' ),
                'current' => get_current_blog_id() == $site->blog_id
            );
        }

        return $results;
    }

    public function createInvitations( Request $request )
    {
        global $wpdb;
        $user = wp_get_current_user();

        $expert_codes = json_decode(get_user_meta( $user->ID, 'invitation_codes', true ));

        if(!is_array($expert_codes)){
            // add new espert codes

            $result = $wpdb->get_results( "
                SELECT
                    `expert_code`
                FROM
                    `{$wpdb->prefix}expert_codes`;
            ", ARRAY_A );
            $excodes = array_column($result, 'expert_code');

            $expert_codes = [];
            for($i = 0; $i < 3; $i++){
                $code = generateRandomString(6);
                while(in_array($code, $excodes)){
                    $code = generateRandomString(6);
                }
                $expert_codes[] = $code;
            }

            $sql = "
                INSERT INTO
                    `{$wpdb->prefix}expert_codes`
                (
                    `expert_code`,
                    `expert_code_name`,
                    `sales_rep_user_id`,
                    `usages`
                ) VALUES
            (\"" . implode( '", "", 0, 1), ("', $expert_codes )."\", \"\", 0, 1)";

            $wpdb->query( $sql );
            add_user_meta( $user->ID, 'invitation_codes', json_encode($expert_codes), true );

        }

        //send mail

        wp_mail( 
            $user->data->user_email, 
            __("Your Invitationcodes", 'rxts'), 
            vsprintf(__("Here are your expert Codes: [%s] [%s] [%s]", 'rxts'), $expert_codes)
        );

        return __("A Message with your Invitationcodes has ben send to your Email.", 'rxts');
    }

    public function jobRoles( Request $request )
    {
        $roles = apo_get_job_roles();
        $return = Array();

        if(is_array($roles) && count($roles) > 0){
            foreach($roles as $role){
                $return[] = $role['value'];
            }
        }
        return $return;
    }

    public function showVoucher( Request $request )
    {
        global $wpdb;
        $return = Array(
            "is_available" => true,
            "message" => ""
        );

        $user = wp_get_current_user();
        $is_pending = get_user_meta( $user->ID, 'is_pending', true );
        
        $locale = get_locale();

        if( $is_pending == "1" ) {
            $return['is_available'] = false;
            $return['message'] = "pages.redeem.hint.isPendingState";
        }else{
            $maximal_points = get_option( 'apo_max_expertpoints', 0 );
            $month = get_option( 'apo_capping_month', 1 );
            $day = get_option( 'apo_capping_day', 1 );

            $timestamp = mktime(0, 0, 0, $month, $day);
            if ($timestamp > time()) {
                $timestamp = mktime(0, 0, 0, $month, $day, date('Y') - 1);
            }

            $points = $wpdb->get_row("SELECT
                                      SUM(points_earned) AS total_points
                                    FROM
                                      {$wpdb->prefix}expert_points AS ep
                                    WHERE
                                        user_id = {$user->ID} AND points_earned < 0 AND created_at >= '".date('Y-m-d H:i:s', $timestamp)."'");

            $dateDiff = date_diff(new DateTime("now"), new DateTime(date('Y-m-d H:i:s', $timestamp)));

            if($dateDiff->m >= 9){
                if(abs($points->total_points) > ($maximal_points) - 50){
                    $return['is_available'] = false;
                    $return['message'] = sprintf(__("Sorry, you already redeem the amount of expert points available per year. Please try again after [%s].", 'rxts'), date('d.m.Y', strtotime('+ 12 months', $timestamp)));
                }
            }elseif($dateDiff->m >= 6){
                if(abs($points->total_points) > ($maximal_points * 0.75) - 50){
                    $return['is_available'] = false;
                    $return['message'] = sprintf(__("Sorry, you already redeem the amount of expert points available per year. Please try again after [%s].", 'rxts'),  date('d.m.Y', strtotime('+ 9 months', $timestamp)));
                }
            }elseif($dateDiff->m >= 3){
                if(abs($points->total_points) > ($maximal_points * 0.5) - 50){
                    $return['is_available'] = false;
                    $return['message'] = sprintf(__("Sorry, you already redeem the amount of expert points available per year. Please try again after [%s].", 'rxts'), date('d.m.Y', strtotime('+ 6 months', $timestamp)));
                }
            }else{
                if(abs($points->total_points) > ($maximal_points * 0.25) - 50){
                    $return['is_available'] = false;
                    $return['message'] = sprintf(__("Sorry, you already redeem the amount of expert points available per year. Please try again after [%s].", 'rxts'), date('d.m.Y', strtotime('+ 3 months', $timestamp)));
                }
            }
        }

        return $return;
    }

    public function formLocations( Request $request )
    {
        global $apo_form_locations;

        $formLocations = array_map(function($form) {
            return [
                'title' => $form['title'],
                'id' => get_option( $form['key'], null ),
                'key' => $form['key'],
            ];
        }, $apo_form_locations);

        return $formLocations;
    }

}