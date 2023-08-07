<?php
error_reporting(E_ALL);
require_once( dirname( __FILE__ ) . '/admin.php' );

global $wpdb;
// filename for export
$csv_filename = 'users_export_'.date('Y-m-d').'.csv';

// create var to be filled with export data
$csv_export = '';

if(isset($_GET['newsletter'])){
  $filters = "";
  $current_blog_id = get_current_blog_id();
  $format = get_option( 'date_format' );

  if(strlen(trim($_POST['active']['training']) > 0))
  $filters .= " AND ".count(explode(',', $_POST['active']['training']))." = (SELECT COUNT(training_id) FROM {$wpdb->prefix}training_user_results wptur WHERE wptur.user_id = wpu.ID AND wptur.is_complete = '1' AND training_id IN ({$_POST['active']['training']}) ".(strlen(trim($_POST['date']) > 0) ? "AND created_at < '{$_POST['date']}'" : "")." )";
if(strlen(trim($_POST['inactive']['training']) > 0))
  $filters .= " AND 0 = (SELECT COUNT(training_id) FROM {$wpdb->prefix}training_user_results wptur WHERE wptur.user_id = wpu.ID AND wptur.is_complete = '1' AND training_id IN ({$_POST['inactive']['training']}))";
if(strlen(trim($_POST['active']['survey']) > 0))
  $filters .= " AND ".count(explode(',', $_POST['active']['survey']))." = (SELECT COUNT(survey_id) FROM {$wpdb->prefix}survey_user_results wpsur WHERE wpsur.user_id = wpu.ID AND wpsur.is_complete = '1' AND survey_id IN ({$_POST['active']['survey']}) ".(strlen(trim($_POST['date']) > 0) ? "AND created_at < '{$_POST['date']}'" : "")." )";
if(strlen(trim($_POST['inactive']['survey']) > 0))
  $filters .= " AND 0 = (SELECT COUNT(survey_id) FROM {$wpdb->prefix}survey_user_results wpsur WHERE wpsur.user_id = wpu.ID AND wpsur.is_complete = '1' AND survey_id IN ({$_POST['inactive']['survey']}))";

  // query to get data from database
  $query = $wpdb->get_results(
    "SELECT
    wpu.*,
    wpum_first.meta_value AS first_name,
    wpum_last.meta_value AS last_name
FROM
    wp_users AS wpu
LEFT JOIN
    wp_usermeta AS wpum_first ON wpu.ID = wpum_first.user_id AND wpum_first.meta_key = 'first_name'
LEFT JOIN
    wp_usermeta AS wpum_last ON wpu.ID = wpum_last.user_id AND wpum_last.meta_key = 'last_name'
WHERE
    EXISTS (
        SELECT 1
        FROM wp_usermeta AS wpum_blog
        WHERE wpu.ID = wpum_blog.user_id
        AND wpum_blog.meta_key = 'primary_blog'
        AND wpum_blog.meta_value = '{$current_blog_id}'
    )
    AND
    (
        EXISTS (
            SELECT 1
            FROM wp_usermeta AS wpum_newsletter
            WHERE wpu.ID = wpum_newsletter.user_id
            AND wpum_newsletter.meta_key = 'accepted_newsletter'
            AND wpum_newsletter.meta_value = 'data_protection_regulations'
        )
    )
    {$filters}
ORDER BY
    wpu.user_registered DESC");

}else{
  // query to get data from database
  $query = $wpdb->get_results('SELECT ID, user_login, display_name, user_email FROM wp_users ORDER BY display_name ASC');
}

$csv_export.= 'ID,LOGIN,FIRSTNAME,LASTNAME,E-MAIL,LASTLOGIN';
$csv_export.= "\n";

foreach ($query as $row) {
  if(isset($_GET['newsletter'])){
    $dates = maybe_unserialize(maybe_unserialize($row->last_login));
    if(is_array($dates) && count($dates) > 0){
        $date = date_i18n($format, $dates[count($dates)-1]);
    }else{
        $date = "-";
    }
    $csv_export.= $row->ID.','.$row->user_login.','.$row->first_name.','.$row->last_name.','.$row->user_email.','.$date.'';
    $csv_export.= "\n";
  }
  elseif(get_user_meta($row->ID, 'primary_blog', true) == get_current_blog_id()) {
    $dates = maybe_unserialize(maybe_unserialize($row->last_login));
    if(is_array($dates) && count($dates) > 0){
        $date = date_i18n($format, $dates[count($dates)-1]);
    }else{
        $date = "-";
    }
    $csv_export.= $row->ID.','.$row->user_login.','.get_userdata($row->ID)->first_name.','.get_userdata($row->ID)->last_name.','.$row->user_email.','.$date.'';
    $csv_export.= "\n";
  }
}

// Export the data and prompt a csv file for download
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);
?>
