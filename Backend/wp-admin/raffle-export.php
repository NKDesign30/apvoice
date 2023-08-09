<?php
error_reporting(E_ALL);
require_once( dirname( __FILE__ ) . '/admin.php' );

$raffleId = $_GET['id'];
$raffleTitle = get_the_title($raffleId);
$url = get_option( 'apo_frontend_url', null );

global $wpdb;

$participants = $wpdb->get_results("SELECT
                                      wpu.ID,
                                      user_email,
                                      contest,
                                      firstName,
                                      lastName,
                                      pharmacyCity,
                                      pharmacyName,
                                      pharmacyStreet,
                                      pharmacyCountry,
                                      pharmacyZipCode,
                                      pharmacyStreetNumber,
																			meta_value AS raffle_type
                                    FROM
                                      {$wpdb->prefix}apo_raffle wpar
                                    JOIN
                                      wp_users wpu ON wpu.ID = wpar.user_id
                                    JOIN
                                      {$wpdb->prefix}postmeta wppm ON wpar.raffle_id = wppm.post_id AND wppm.meta_key = 'contest_type'
                                    WHERE
                                      raffle_id = $raffleId");
$tableHeadlines = [];

if(count($participants) > 0)
  $tableHeadlines = array_keys(get_object_vars($participants[0]));

// filename for export
$csv_filename = 'raffle_'.rawurlencode($raffleTitle).'_export_'.date('Y-m-d').'.csv';

// create var to be filled with export data
$csv_export = '';

foreach ($tableHeadlines as $headline) {
  $csv_export.= substr($headline, 0, 30).',';
}

$csv_export.= '
';

foreach ($participants as $row) {
  foreach ($row as $key => $value) {
    if($key == "contest"){
      $path = $url.'/wp-json/apovoice/v1/media?p=/raffles/'.$value;
      if($row->raffle_type == 'Upload'){
        $value = $path;
      }

      $csv_export.= '"'.$value.'",';
    } else {
      $csv_export.= '"'.$value.'",';
    }
  }
  $csv_export.= "\n";
}

// Export the data and prompt a csv file for download
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);
?>
