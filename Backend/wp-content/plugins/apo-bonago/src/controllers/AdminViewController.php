<?php

namespace apo\bonago\controllers;

use apo\bonago\models\Voucher;
use apo\bonago\roles\BonagoVoucherManagerRole;
use awsm\wp\libraries\Controller;

class AdminViewController extends Controller
{

    /**
     * The date format from the WordPress backend
     */
    protected $dateFormat;

    /**
     * The time format from the WordPress backend
     */
    protected $timeFormat;

    /**
     * Set the default voucher filter
     */
    protected $defaultVoucherFilter = 'all';

    public function __construct()
    {
        parent::__construct();
        $this->viewDirectory = APO_BONAGO_VIEWS_DIR;
        $this->voucher = new Voucher();

        $this->dateFormat = get_option( 'date_format' );
        $this->timeFormat = get_option( 'time_format' );
    }

    /**
     * Prepare the data for the bonago vouchers admin view
     * 
     * @return template 
     */
    public function bonagoVouchers()
    {
        $data = [
            'amount' => $this->voucher->getAmountCollection(),
            'vouchers' => $this->mapVouchers($this->voucher->showByQueryParams($this->getQueryParams())),
            'payload' => $this->getPayload(),
            'messageClasses' => $this->getMessageClasses(),
            'filter' => $this->getFilter(),
            'can_manage' => current_user_can( BonagoVoucherManagerRole::MANAGE_CAPABILITY ),
        ];

        return $this->view('bonago-vouchers', $data);
    }

    private function mapVouchers($vouchers)
    {
        return array_map( function( $voucher ) {

            $voucher->assigned = $this->codeToWord($voucher->assigned);
            $voucher->redeemed = $this->codeToWord($voucher->redeemed);
            $voucher->assigned_at = $this->createDateTime($voucher->assigned_at);
            $voucher->redeemed_at = $this->createDateTime($voucher->redeemed_at);
            $voucher->created_at = $this->createDateTime($voucher->created_at);
            $voucher->updated_at = $this->createDateTime($voucher->updated_at);
            $voucher->expires_at = $this->createDate($voucher->expires_at);
            $voucher->user = $this->mapUser($voucher->user_id);

            return $voucher;
        }, $vouchers);
    }

    private function mapUser($user_id)
    {
        $user = get_user_by('ID', $user_id);
        return [
            'name' => $user->display_name,
            'link' => get_edit_user_link($user_id),
            'email' => $user->user_email,
        ];
    }

    private function createDate($date)
    {
        if(is_null($date)) return;

        return date_i18n( $this->dateFormat, strtotime( $date ) );
    }

    private function createTime($time)
    {
        if(is_null($time)) return;

        return date_i18n( $this->timeFormat, strtotime( $time ) );
    }

    private function createDateTime($date)
    {
        if(is_null($date)) return;
        return "{$this->createDate($date)} {$this->createTime($date)}";
    }

    private function codeToWord($code)
    {
        switch ($code) {
            case 0:
                return __('No', 'apovoice-bonago');
                break;
            
            case 1:
                return __('Yes', 'apovoice-bonago');
                break;
            
            default:
                return $code;
                break;
        }
    }

    private function getQueryParams()
    {
        return [
            'filter' => $this->getFilter(),
            's' => $this->getSearchParam(),
        ];
    }

    private function getFilter()
    {
        return $_GET['filter'] ?? $this->defaultVoucherFilter;   
    }

    private function getSearchParam()
    {
        return $_GET['s'] ?? null;
    }

    private function getPayload()
    {
        $payload = unserialize( base64_decode( $_GET['payload'] ?? '' ) );
        return $payload ? $payload : [];
    }

    private function getMessageClasses()
    {
        return [
            'infos' => 'updated notice',
            'errors' => 'error notice',
            'notices' => 'update-nag notice',
        ];
    }

}