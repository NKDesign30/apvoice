<?php

namespace raffle\models;

use awsm\wp\libraries\Model;

class Raffle extends Model
{
    protected $fillable = [
        'raffle_id',
        'contest',
        'firstName',
        'lastName',
        'pharmacyCity',
        'pharmacyName',
        'pharmacyStreet',
        'pharmacyCountry',
        'pharmacyZipCode',
        'pharmacyStreetNumber',
        'user_id',
    ];

	public function __construct()
	{
        parent::__construct('apo_raffle');
    }

    public function showByUser($user = null)
    {
        $query = $this->db->select('SELECT * FROM ' . $this->table . ' WHERE user_id = ' . $this->currentUserId($user) );
        return $query;
    }

}
