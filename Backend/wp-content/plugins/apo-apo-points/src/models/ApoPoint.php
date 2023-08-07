<?php

namespace apo\apopoints\models;

use awsm\wp\libraries\Model;

class ApoPoint extends Model
{
    protected $fillable = [
        'user_id',
        'points_earned',
        'related_type',
        'related_id',
    ];

    protected $unique = [
        'user_id',
        'related_type',
        'related_id',
    ];

	public function __construct() 
	{
        parent::__construct('apo_points');
    }
    
    public function showByUser($user = null) 
    {
        $query = $this->db->select('SELECT * FROM ' . $this->table . ' WHERE user_id = ' . $this->currentUserId($user) );
        return $query;
    }

    public function showSumByUser($user = null)
    {
        $query = $this->db->selectRow('SELECT SUM(points_earned) as apo_points FROM ' . $this->table . ' WHERE user_id = ' . $this->currentUserId($user) );
        return $query;
    }

    public function getUsersApoPoints()
    {
        return $this->showSumByUser()->apo_points;
    }
	
}
