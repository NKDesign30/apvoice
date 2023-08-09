<?php

namespace apo\bonago\models;

use awsm\wp\libraries\Model;

class VoucherUser extends Model
{
    protected $fillable = [
        'voucher_code_id',
        'user_id',
    ];

    protected $unique = [
        'voucher_code_id',
        'user_id',
    ];

	public function __construct() 
	{
        parent::__construct('bonago_voucher_user');
    }
	
}
