<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsPerActivation extends Model 
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'activation_name',
        'total_activations',
        'date',
    ];

    protected $unique = [
        'activation_name',
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_activation');
    }

    public function run($date)
    {
        foreach ($this->processStats($this->getDailyStatsPerActivation($date), $date) as $stats) {
            $result[] = $this->createStats($stats);
        }
        return $result;
    }

    function processStats($data, $date){
        $statsArr = Array();
        foreach($data AS $row){
            if(trim($row->usages) != '')
                $statsArr[$row->activation_name] += $row->activations;
            else{
                $key = strlen(trim($row->activation_name)) > 0 ? $row->activation_name : $row->expert_code;
                $statsArr[$key] += $row->activations;
            }
        }
        $res = Array();
        foreach($statsArr AS $key => $val)
            $res[] = ['activation_name' => $key, 'total_activations' => $val, 'date' => $date];

        return $res;
    }

    public function getReportingResults($startDate, $endDate)
    {
        $sql = $this->db->prepare("
            SELECT
                `{$this->table}`.`activation_name`,
                COALESCE( MAX(`{$this->table}`.`total_activations`), 0) as `total_activations`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` BETWEEN %s AND %s
            GROUP BY
                `{$this->table}`.`activation_name`
        ", $startDate, $endDate);

        $period = $this->db->select($sql);

        $sql = $this->db->prepare("
            SELECT
                `{$this->table}`.`activation_name`,
                COALESCE( MAX(`{$this->table}`.`total_activations`), 0) as `total_activations`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` < %s
            GROUP BY
                `{$this->table}`.`activation_name`
        ", $startDate);

        $prev = $this->db->select($sql);

        foreach($period AS $key => &$row){
            foreach($prev AS $row2){
                if($row2->activation_name == $row->activation_name){
                    $row->previous_data = $row2;
                    break;
                }
            }
        }
        
        return $period;
    }

    public function showOrderByDesc()
    {
        return $this->db->select('SELECT * FROM ' . $this->table . ' ORDER BY date DESC');
    }
	
}
