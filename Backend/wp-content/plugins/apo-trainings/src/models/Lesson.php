<?php

namespace apo\trng\models;

use awsm\wp\libraries\Model;

class Lesson extends Model
{

    protected $fillable = [
        'training_id',
        'user_id',
        'lesson_id',
    ];

    protected $unique = [
        'training_id',
        'user_id',
        'lesson_id',
    ];

	public function __construct() 
	{
        parent::__construct('training_user_lessons');
    }
    
    public function showByUser($user = null) 
    {
        $query = $this->db->select('SELECT * FROM ' . $this->table . ' WHERE user_id = ' . $this->currentUserId($user) );
        return $query;
    }

    public function showByTraining($training, $user = null) 
    {
        $query = $this->db->select('SELECT * FROM ' . $this->table . ' WHERE training_id = ' . $training . ' AND user_id = ' . $this->currentUserId($user));
        return $query;
    }

    public function showByLesson($lesson, $user = null) 
    {
        $query = $this->db->selectRow('SELECT * FROM ' . $this->table . ' WHERE lesson_id = ' . $lesson . ' AND user_id = ' . $this->currentUserId($user));
        return $query;
    }

    public function getCompletedLessons($training, $user = null)
    {
        $query = $this->db->select('SELECT lesson_id FROM ' . $this->table . ' WHERE training_id = ' . $training . ' AND user_id = ' . $this->currentUserId($user));
        $lessons = array_column($query, 'lesson_id');
        return $lessons;
    }

    public function getLessonIds($training)
    {
        return array_map(function($lesson) {
            return $lesson['lesson']['lesson_id'];
        }, get_fields($training)['lessons']);
    }
	
}
