<?php

/*
Plugin Name: Apovoice PGCI Users DE
Plugin URI: https://apovoice.es/
Description: Apovoice PGCI Users
Version: 1.0.0
Author: Apovoice
Author URI:  https://apovoice.es/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apo-pgci-user
 */
define('APO_PGCI_USER_TABLE_PGCI_USER', 'wp_2_apovoice_pgci_user');
define('APO_PGCI_USER_TABLE_PGCI', 'wp_2_apovoice_pgci');
define('APO_PGCI_USER_TABLE_USERMETA', 'wp_usermeta');


/**
 * Add apo pgci user match schedule after activation
 */
function apoPGCIUserAddSchedule() {
    if (!wp_next_scheduled('match_apovoice_pgci_user')) {
        wp_schedule_event(time(), 'every_three_minutes', 'match_apovoice_pgci_user');
  }
}
register_activation_hook(__FILE__, 'apoPGCIUserAddSchedule');


add_filter( 'cron_schedules', function () {
    $schedules['every_three_minutes'] = array(
        'interval'  => 180,
        'display'   => __( 'Every 3 Minutes', 'textdomain' )
    );
    return $schedules;
});

/**
 * Remove apo pgci user match schedule after deactivation
 */
function apoPGCIUserRemoveSchedule() {
    wp_clear_scheduled_hook('match_apovoice_pgci_user');
}
register_deactivation_hook(__FILE__, 'apoPGCIUserRemoveSchedule');


/**
 * Create the table wp_2_apovoice_pgci_user after plugin activation
 */
function apoPGCIUserCreateDatabaseTable() {
    global $wpdb;

    // Set table name
    $table_name = APO_PGCI_USER_TABLE_PGCI_USER;

    // Set charset
    $charset_collate = $wpdb->get_charset_collate();

    // SQl create query
    $sql = "CREATE TABLE $table_name (id mediumint(9) NOT NULL AUTO_INCREMENT, pgci_id mediumint(9) NOT NULL, user_id mediumint(9) NOT NULL, PRIMARY KEY  (id)) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Run sql
    dbDelta( $sql );
}

/**
 * Hook after activate plugin
 */
register_activation_hook( __FILE__, function() {
    apoPGCIUserCreateDatabaseTable();
});

/**
 * Get all entries in the wp_2_apovoice_pgci table.
 */
function apoPGCIGetEntries()
{
    global $wpdb;
    $table_name = APO_PGCI_USER_TABLE_PGCI;
    return $wpdb->get_results( "SELECT * FROM $table_name ORDER BY updated_at ASC LIMIT 500");
}

/**
 * Delete all entries in the wp_2_apovoice_pgci_user table by id.
 */
function apoPGCIClearEntriesById($id)
{
    global $wpdb;
    $wpdb->delete(APO_PGCI_USER_TABLE_PGCI_USER, array( 'pgci_id' => $id));
}

/**
 * Find users by pharma name and zipcode
 */
function apoPGCIFindUsers($name, $zipcode)
{
    global $wpdb;
    $table_name = APO_PGCI_USER_TABLE_USERMETA;

    return $wpdb->get_results( "SELECT * FROM $table_name WHERE meta_key = 'expert_only_pharmacies' 
                AND meta_value LIKE '%". trim($name) . "%' AND meta_value LIKE '%" . $zipcode . "%'");
}

/**
 * Update the wp_2_apovoice_pgci_user Table
 */
function apoPGCIInserUser($userId, $pgciId)
{
    global $wpdb;
    $wpdb->insert(APO_PGCI_USER_TABLE_PGCI_USER, array(
        'pgci_id' => $pgciId,
        'user_id' => $userId
    ));
}

/**
 * @param $pgciId
 */
function apoPGCIUpdateRow($pgciId)
{
    global $wpdb;
    $wpdb->update(
        APO_PGCI_USER_TABLE_PGCI,
        array('updated_at' => date('Y-m-d H:i:s')),
        array('id' => $pgciId)
    );
}

/**
 * Get all entries in the wp_2_apovoice_pgci table.
 * Then find the corresponding user in the wp_usermeta table and update the wp_2_apovoice_pgci_user Table.
 */
function apoPGCIUserUpdate()
{
    $results = apoPGCIGetEntries();
    foreach ($results as $result) {
        echo "PGCI: " . $result->id;
        echo "<br />";
        apoPGCIClearEntriesById($result->id);
        apoPGCIUpdateRow($result->id);

        $metaItems = apoPGCIFindUsers($result->name, $result->zip_code);
        echo "Matches: " . count($metaItems);
        echo "<br /><br />";

        if ($metaItems) {
            foreach ($metaItems as $metaItem) {
                apoPGCIInserUser($metaItem->user_id, $result->id);
            }
        }
    }
}

/**
 * Get all entries in the wp_2_apovoice_pgci table.
 * Then find the corresponding user in the wp_usermeta table and update the wp_2_apovoice_pgci_user Table.
 */
add_action('match_apovoice_pgci_user', 'apoPGCIUserUpdate');
