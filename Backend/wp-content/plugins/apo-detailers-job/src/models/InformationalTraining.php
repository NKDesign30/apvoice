<?php

namespace apo\detailersjob\models;

use awsm\wp\libraries\Model;

class InformationalTraining extends Model
{
    protected $fillable = [];

    protected $unique = [];

	public function __construct()
	{
        parent::__construct('detailers_job_saved_state');
    }

    public function all( $detailer_user_id )
    {
        return $this->db->select( $this->db->wpdb->prepare( "
            SELECT
                *
            FROM
                `{$this->table}`
            WHERE
                `detailer_user_id` = %d
        ", $detailer_user_id ) );
    }

    public function saveState( $data )
    {
        $informational_training_id = $data['informational_training_id'];
        $pharmacy_id = $data['pharmacy_id'];
        $detailer_user_id = $data['detailer_user_id'];
        $last_question_id = $data['last_question_id'];

        $this->deleteSavedState( $informational_training_id, $pharmacy_id, $detailer_user_id );

        $this->db->insert(
            $this->table,
            [
                'informational_training_id' => $informational_training_id,
                'pharmacy_id' => $pharmacy_id,
                'detailer_user_id' => $detailer_user_id,
                'last_question_id' => $last_question_id,
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
            ],
            [
                '%d',
                '%d',
                '%d',
                '%s',
            ]
        );

        return $this->db->selectRow( $this->db->wpdb->prepare( "
            SELECT
                *
            FROM
                `{$this->table}`
            WHERE
                `informational_training_id` = %d AND
                `pharmacy_id` = %d AND
                `detailer_user_id` = %d
        ", [$informational_training_id, $pharmacy_id, $detailer_user_id] ) );
    }

    public function savedState( $userId )
    {
        return $this->db->select( "
            SELECT
                *
            FROM
                `{$this->table}`
            WHERE
                `detailer_user_id` = {$userId}
        " );
    }

    public function clearSavedState( $data ) {
        $this->db->delete( $this->table, [
            'informational_training_id' => $data['informational_training_id'],
            'pharmacy_id' => $data['pharmacy_id'],
            'detailer_user_id' => $data['detailer_user_id'],
        ] );
    }

    public function deleteSavedState( $informational_training_id, $pharmacy_id, $detailer_user_id ) {
        $this->db->delete( $this->table, [
            'informational_training_id' => $informational_training_id,
            'pharmacy_id' => $pharmacy_id,
            'detailer_user_id' => $detailer_user_id,
        ] );
    }
}
