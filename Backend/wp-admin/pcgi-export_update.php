<?php

require_once( dirname( __FILE__ ) . '/admin.php' );

global $wpdb;

$apovoice_pgci = $wpdb->get_results("SELECT id,bga_id,name,house_nr,street,zip_code,city FROM {$wpdb->prefix}apovoice_pgci");

$tableHeadlines = [];

function toCsv($data) {
    ob_start();
    $file = fopen("php://output", 'w');

    $tableHeadlines = array_keys(get_object_vars($data[0]));
    $formattedData = json_decode(json_encode($data), true);

    fputcsv($file, $tableHeadlines);
    foreach ($formattedData as $row) {
        fputcsv($file, $row);
    }
    fclose($file);

    return ob_get_clean();
}

if(count($apovoice_pgci) > 0) {
    $csvFilename = 'apovoice_pgci_export_'.date('Y-m-d').'.csv';
    header('Content-Type: text/csv');
    header("Content-Disposition: attachment; filename=".$csvFilename."");

    echo toCsv($apovoice_pgci);
}
