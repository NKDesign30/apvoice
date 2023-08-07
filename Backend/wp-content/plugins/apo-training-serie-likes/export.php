<?php

require_once __DIR__ . '/../../../wp-load.php';

$data = array();
$sql = "SELECT `{$wpdb->prefix}training_series_reporting`.*,
                (SELECT count(*) FROM {$wpdb->prefix}apo_points WHERE related_id=`{$wpdb->prefix}training_series_reporting`.training_series_id AND 
                    related_type = 'training-series') as total
                FROM `{$wpdb->prefix}training_series_reporting`";
$result = $wpdb->get_results($sql, 'ARRAY_A');

foreach ($result as $item) {
    $trainingSeries = get_post($item['training_series_id']);
    $data[] = [
        'training_series_id' => $item['training_series_id'],
        'training_name' => $trainingSeries->post_title,
        'training_total' => $item['total'],
        'likes' => $item['likes'],
    ];
}

$csv = 'trianing_series_id;training_name;total;likes;';
foreach ($data as $dataItem) {
    $csv .= "\n" . implode(";", $dataItem);
}

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=training_series_export_".time().".csv");
header("Pragma: no-cache");
header("Expires: 0");

echo $csv;


exit;