<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsPerDownload extends Model 
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'download_id',
        'download_title',
        'total_downloads',
        'product_title',
        'download_mediatype',
        'date',
    ];

    protected $unique = [
        'download_id',
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_download');
    }

    public function run($date)
    {
        foreach ($this->getDailyStatsPerDownload($date) as $stats) {
            $result[] = $this->createStats($stats);
        }
        return $result;
    }

    public function getReportingResults($startDate, $endDate)
    {
        $sql = $this->db->prepare("
            SELECT
                `{$this->table}`.`download_title`,
                `{$this->table}`.`product_title`,
                COALESCE( MAX(`{$this->table}`.`total_downloads`), 0) as `total_downloads`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` BETWEEN %s AND %s
            GROUP BY
                `{$this->table}`.`download_id`
        ", $startDate, $endDate);

        $per_downloads = $this->db->select($sql);

        $sql = $this->db->prepare("
            SELECT
                `{$this->table}`.`product_title`,
                COALESCE( SUM(`{$this->table}`.`total_downloads`), 0) as `total_downloads`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` = %s
            GROUP BY
                `{$this->table}`.`product_title`
        ", $endDate);

        $per_product = $this->db->select($sql);

        return Array('per_downloads' => $per_downloads, 'per_product' => $per_product);
    }

    public function showOrderByDesc()
    {
        return $this->db->select('SELECT * FROM ' . $this->table . ' ORDER BY date DESC');
    }
	
}
