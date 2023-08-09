<?php

namespace apo\trng\models;

use awsm\wp\libraries\Model;

class Training extends Model
{
    protected $fillable = [
        'user_id',
        'training_id',
        'result',
        'is_complete',
    ];

    protected $unique = [
        'user_id', 
        'training_id'
    ];

	public function __construct() 
	{
        parent::__construct('training_user_results');
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

    public function finish($training, $user = null) 
    {
        $query = $this->update(
            ['is_complete' => true], 
            ['training_id' => $training, 'user_id' => $this->currentUserId($user)]
        );
        return $query;
    }

      public function update_user_apo_points($training_id, $data,$user= null)
    {
        global $wpdb;
        $site_id = $this->get_current_site_id();
        $apo_points_table =  $wpdb->get_blog_prefix($site_id).'apo_points';
        $posts_table = $wpdb->get_blog_prefix($site_id).'posts';
        
        $trainign_series_id = $data['training_series_id'];
        $informations = get_field('informations', $trainign_series_id);

        $USER_ID = $this->currentUserId($user);

        $check_already_earned_sql = "SELECT * FROM $apo_points_table WHERE user_id = $USER_ID AND related_id=$trainign_series_id";
        $wpdb->get_results($check_already_earned_sql);
        if($wpdb->num_rows == 0)
        {
           $insert = $wpdb->insert($apo_points_table, array(
                'user_id'       => $this->currentUserId($user),
                'points_earned' => (int)$informations['apo_points'],
                'related_type'  => 'training-series',
                'related_id'    => $trainign_series_id
            ));

            if(!$insert) {
                echo "failed training insertion";
            }
        }
    }

    public function get_current_site_id()
    {
        global $wpdb;

        $b_id =  get_current_blog_id();
        $PORT = $_SERVER['SERVER_PORT'];
        if(!empty($PORT)) {
            if($PORT == '85') {
                $b_id = 2;
            } else if($PORT == '90') {
                $b_id = 3;
            } else if($PORT == '95') {
                $b_id = 4;
            }
        }
        return $b_id;
    }

	
}
