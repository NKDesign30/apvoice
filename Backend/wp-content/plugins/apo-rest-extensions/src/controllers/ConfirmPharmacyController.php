<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;

class ConfirmPharmacyController extends Controller
{
    use Auth;
    
	public function __construct()
	{
        parent::__construct();
	}

    public function index( Request $request)
    {
        $pharmacies = json_decode(get_user_meta( $this->currentUser()->ID, 'expert_only_pharmacies', true ));

        $pharmacy =  array_combine(
            array_column($pharmacies[0], 'title'),
            array_column($pharmacies[0], 'value')
        );
        return [
            'pharmacy' => $pharmacy,
        ];
    }

    public function store( Request $request)
    {
        $data = $request->get_params();
        $pharmacy = [
            [
                [
                    'title' => 'pharmacyName',
                    'value' => $data['name'],
                ],
                [
                    'title' => 'pharmacyCountry',
                    'value' => $data['country'],
                ],
                [
                    'title' => 'pharmacyStreet',
                    'value' =>  $data['street'],
                ],
                [
                    'title' => 'pharmacyStreetNo',
                    'value' =>  $data['number'],
                ],
                [
                    'title' => 'pharmacyZipCode',
                    'value' =>  $data['zip'],
                ],
                [
                    'title' => 'pharmacyCity',
                    'value' =>  $data['city'],
                ],
            ],
        ];

        update_user_meta( $this->currentUser()->ID, 'expert_only_pharmacies', json_encode($pharmacy, JSON_UNESCAPED_UNICODE) );
        update_user_meta( $this->currentUser()->ID, 'has_updated_pharmacy_address', true );
        return $pharmacy;
    }

}
