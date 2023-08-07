<?php
error_reporting(E_ALL);
require_once( dirname( __FILE__ ) . '/admin.php' );
global $wpdb;

// query to get data from database
$query = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_value LIKE '%https://apovoicenonprodstorage.pg.com%'");
$url = get_option( 'apo_frontend_url', null );

foreach ($query as $row) {
  $data = maybe_unserialize($row->meta_value);

  $data['url'] = str_replace('https://apovoicenonprodstorage.pg.com', $url.'/wp-json/apovoice/v1/media?p=', $data['url']);

  $execute = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}postmeta SET meta_value = %s WHERE meta_id = %s", maybe_serialize($data), $row->meta_id ) );
  var_dump($execute);
}

$execute = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}posts SET guid = replace(guid,'https://apovoicenonprodstorage.pg.com','{$url}/wp-json/apovoice/v1/media?p=');" ) );
var_dump($execute);

?>
