<?php

namespace knwldg\models;

use awsm\wp\libraries\Model;

class KnowledgeBase extends Model
{
	public function __construct() 
	{
        parent::__construct('apo_knowledge_base');
    }
    
    public function showByUser($user = null) 
    {
        $query = $this->db->select('SELECT * FROM ' . $this->table . ' WHERE user_id = ' . $this->currentUserId($user) );
        return $query;
    }
	
}
