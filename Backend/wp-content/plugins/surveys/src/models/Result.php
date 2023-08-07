<?php

namespace apo\svy\models;
use awsm\wp\libraries\Model;

class Result extends Model
{
    protected $fillable = [
        'user_id',
        'survey_id',
        'result',
        'is_complete',
    ];

	public function __construct() 
	{
        parent::__construct('survey_user_results');
    }
    
    /**
     * Getters
     */

    public function showByUser($user = null) 
    {
        $query = $this->db->select('SELECT * FROM ' . $this->table . ' WHERE user_id = ' . $this->currentUserId($user) );
        return $query;
    }

    public function showBySurvey($survey, $user = null) 
    {
        $query = $this->db->selectRow('SELECT * FROM ' . $this->table . ' WHERE survey_id = ' . $survey . ' AND user_id = ' . $this->currentUserId($user));
        return $query;
    }
	
}
