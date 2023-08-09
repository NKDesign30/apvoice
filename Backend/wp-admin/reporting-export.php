<?php
error_reporting(E_ALL);
require_once( dirname( __FILE__ ) . '/admin.php' );

$raffleId = $_GET['id'];
$raffleTitle = get_the_title($raffleId);
$url = get_option( 'apo_frontend_url', null );

global $wpdb;

$participants = $wpdb->get_results("SELECT
                                      (SELECT display_name FROM wp_users WHERE wp_users.ID = adspsr.sales_rep_user_id) as `Sales Rep`,
                                      wpu.display_name as User,
                                      wpu.user_email as email,
                                      adspsr.registered_expert_code as `Registered Expert Code`,
                                      adspsr.pharmacy_unique_number as PUN,
                                      (SELECT meta_value FROM wp_usermeta WHERE wp_usermeta.user_id=adspsr.user_id AND meta_key = 'registered_pg_customer_id') as PGCI,
                                      (SELECT meta_value FROM wp_usermeta WHERE wp_usermeta.user_id=adspsr.user_id AND meta_key = 'wp_user_level') as Level,
                                      adspsr.pharmacy_name as `Pharmacy Name`,
                                      DATE_FORMAT(adspsr.date, '%d. %M %Y') as `Date`,
                                      (SELECT meta_value FROM wp_usermeta WHERE wp_usermeta.user_id=adspsr.user_id AND meta_key = 'login_dates') as `Last Login`
                                    FROM
                                      {$wpdb->prefix}apo_daily_stats_per_sales_rep adspsr
                                    JOIN
                                      wp_users wpu ON wpu.ID = adspsr.user_id");
$tableHeadlines = [];

if(count($participants) > 0)
  $tableHeadlines = array_keys(get_object_vars($participants[0]));

// filename for export
$csv_filename = 'reporting_export_'.date('Y-m-d').'.csv';

// create var to be filled with export data
$csv_export = '';

foreach ($tableHeadlines as $headline) {
  $csv_export.= substr($headline, 0, 30).',';
}

$csv_export.= '
';

$format = get_option( 'date_format' );

foreach ($participants as $row) {
  foreach ($row as $key => $value) {
    if($key == "Date"){
      $csv_export.= '"'.date_i18n($format, strtotime($value)).'",';
    }elseif($key == "Last Login"){
      $dates = maybe_unserialize(maybe_unserialize($value));
      if(is_array($dates) && count($dates) > 0){
        $csv_export.= '"'.date_i18n($format, $dates[count($dates)-1]).'",';
      }else{
        $csv_export.= '"",';
      }
    }else{
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
