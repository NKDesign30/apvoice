<?php

namespace apo\bonago\controllers;

use \WP_Error;
use apo\bonago\models\Voucher;
use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use apo\bonago\models\VoucherUser;
use awsm\wp\libraries\utilities\Auth;
use apo\expertpoints\models\ExpertPoint;
use apo\expertpoints\verifier\ExpertPointsVerifier;
use apo\expertpoints\controllers\ExpertPointsUserController;
use \Datetime;

class VouchersController extends Controller
{
    use Auth;

    /**
     * The redeem type to exchange expert points
     */
    const REDEEM_TYPE = 'bonago';

    /**
     * Fix amount of expert points to earn
     */
    const POINTS_TO_REDEEM = 50;

	public function __construct() 
	{
        parent::__construct();
        $this->expertPoints = new ExpertPoint();
        $this->voucher = new Voucher();
        $this->voucherUser = new VoucherUser();
	}

    /**
     * Assign a voucher to the current user
     */
    public function assign( Request $request )
    {
        $verifier = new ExpertPointsVerifier();

        $payload = [
            'points_earned' => self::POINTS_TO_REDEEM,
            'related_type' => self::REDEEM_TYPE,
        ];

        $verifiedData = $verifier->verify($payload);

        if( is_wp_error($verifiedData)) {
            return $verifiedData;
        } 

        $assignedVoucher = $this->assignToUser();

        if( is_wp_error( $assignedVoucher ) ) {
            return $assignedVoucher;
        }

        $this->associate($assignedVoucher);

        return $this->prepareResponse($assignedVoucher);
    }

    /**
     * The current user redeem a voucher
     */
    public function redeem( Request $request )
    {
        $voucherCode = $request->get_param('voucher_code');

        $voucher = $this->voucher->showUsersVoucher($voucherCode);

        if ( is_null( $voucher ) ) {
            return $this->noVoucherAvailable();
        }

        if ( $voucher->redeemed == 1 ) {
            return $this->voucherAlreadyRedeemed();
        }

        $redeemedVoucher = $this->voucher->redeem( $voucher->id );
        $redeemedVoucher->bonago_url = get_option( 'apo_bonago_vouchers_url' ) . $redeemedVoucher->voucher_code;

        return $this->prepareResponse( $redeemedVoucher );
    }

    /**
     * Get all assigned voucher codes for the current user
     */
    public function user( Request $request )
    {
        $vouchers = array_map( function($voucher) {
            $voucher->expires_at = date_i18n( get_option( 'date_format' ), strtotime(  $voucher->expires_at ) );
            return $voucher;
        },  $this->voucher->showUsersVouchers());

        return $this->prepareResponse( $vouchers );
    }

    protected function associate($voucher)
    {
        if( property_exists($voucher, 'id') ) {
            $voucherRequest = new Request();
            $voucherRequest->set_param('points_earned', self::POINTS_TO_REDEEM);
            $voucherRequest->set_param('related_type', self::REDEEM_TYPE);
            $voucherRequest->set_param('related_id', $voucher->id);
            (new ExpertPointsUserController())->store($voucherRequest);
        }
    }

    private function assignToUser()
    {
        $isCapped = $this->checkVoucherCapping();
        if(is_wp_error($isCapped)){
            return $isCapped;
        }

        $availableVoucher = $this->voucher->showOneAvailable();

        if ( is_null( $availableVoucher ) ) {
            return $this->noVoucherAvailable();
        }

        $this->voucherUser->create( ['voucher_code_id' => $availableVoucher->id, 'user_id' => $this->userId() ] );
        return $this->voucher->assign( $availableVoucher->id );
    }

    private function checkVoucherCapping()
    {
        global $wpdb;
        $return = Array(
            "is_available" => true,
            "message" => ""
        );

        $user = wp_get_current_user();
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

        if(!$return['is_available']){
            return new WP_Error( 
                "exceeded_voucher_capping", 
                $return['message'], 
                array( "status" => 404 ) 
            );
        }else{
            return null;
        }
    }

    private function noVoucherAvailable()
    {
        return new WP_Error( 
            "no_voucher_available", 
            "Oops, that didn't work out. Please contact us.", 
            array( "status" => 404 ) 
        );
    }

    private function voucherAlreadyRedeemed()
    {
        return new WP_Error( 
            "voucher_already_redeemed", 
            "The voucher is already redeemed by you", 
            array( "status" => 403 ) 
        );
    }

} 