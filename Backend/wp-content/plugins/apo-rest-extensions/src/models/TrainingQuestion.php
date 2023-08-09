<?php

namespace apo\rxts\models;

use awsm\wp\libraries\Model;

class TrainingQuestion extends Model
{
    protected $fillable = [
        'user_id',
        'training_id',
        'lesson_id',
        'question_id',
        'question_type',
        'result',
    ];

    protected $unique = [
        'user_id',
        'training_id',
        'lesson_id',
        'question_id',
    ];

	public function __construct() 
	{
        parent::__construct('training_question_user_results');
    }
    
    public function showByUser($user = null) 
    {
        $query = $this->db->select('SELECT * FROM ' . $this->table . ' WHERE user_id = ' . $this->currentUserId($user) );
        return $query;
    }

    public function showByTraining($training, $user = null) 
    {
        $query = $this->db->selectRow('SELECT * FROM ' . $this->table . ' WHERE training_id = ' . $training . ' AND user_id = ' . $this->currentUserId($user));
        return $query;
    }

    public function showByQuestion($question, $user = null) 
    {
        $query = $this->db->selectRow('SELECT * FROM ' . $this->table . ' WHERE question_id = ' . $question . ' AND user_id = ' . $this->currentUserId($user));
        return $query;
    }

    public function showByLesson($lesson, $user = null) 
    {
        $query = $this->db->selectRow('SELECT * FROM ' . $this->table . ' WHERE lesson_id = ' . $lesson . ' AND user_id = ' . $this->currentUserId($user));
        return $query;
    }
	
}
