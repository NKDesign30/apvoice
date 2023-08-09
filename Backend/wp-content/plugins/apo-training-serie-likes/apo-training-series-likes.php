<?php
/*
Plugin Name: Apovoice Training Series Likes
Plugin URI: https://apovoice.es/
Description: Extends the WordPress REST API with custom endpoints and functionality
Version: 1.0.0
Author: Apovoice
Author URI:  https://apovoice.es/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: rxts
 */


if (!defined('ABSPATH')) exit;

define('APO_TRAINING_SERIES_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));

/**
 * Reporting list table
 */
require_once __DIR__ . '/list-table.php';
if (is_admin()) {
    new ApoTrainingSeriesTable();
}

/**
 * REST API Endpoint: Get all likes for a spesific trainingSeriesId
 */
add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v2', '/training-likes/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'apo_training_series_likes'
    ) );
});

function apo_training_series_likes($data)
{
    global $wpdb;

    $trainingSeriesId = (int) $data['id'];
    $userId = get_current_user_id();
    $siteId = get_current_site_id();

    $trainingSeriesReportingTable = $wpdb->get_blog_prefix($siteId) . 'training_series_reporting';
    $trainingSeriesLikesTable = $wpdb->get_blog_prefix($siteId) . 'training_series_likes';

    $likesTableSql = "SELECT count(id) as count FROM `$trainingSeriesLikesTable` WHERE training_series_id=$trainingSeriesId
      GROUP BY (training_series_id)";
    $count = $wpdb->get_results($likesTableSql);
    return($count);
}


/**
 * REST API Endpoint: Check Like for a training series
 */
add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v2', '/check/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'apo_check_like'
    ) );
});
function apo_check_like($data){
    global $wpdb;

    $trainingSeriesId = (int) $data['id'];
    $userId = get_current_user_id();
    $siteId = get_current_site_id();

    $trainingSeriesReportingTable = $wpdb->get_blog_prefix($siteId) . 'training_series_reporting';
    $trainingSeriesLikesTable = $wpdb->get_blog_prefix($siteId) . 'training_series_likes';

    $likesTableSql = "SELECT id FROM `$trainingSeriesLikesTable` WHERE training_series_id=$trainingSeriesId AND user_id=$userId";
    $likesTableResult = $wpdb->get_results($likesTableSql);
    if (empty($likesTableResult)) {
         return(false);
    }else{
        return(true);
    }

}

/**
 * REST API Endpoint: Dislike training series
 */
add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v2', '/dislike/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'apo_training_series_dislike'
    ) );
});



function apo_training_series_dislike($data)
{
    global $wpdb;

    $trainingSeriesId = (int) $data['id'];
    $userId = get_current_user_id();
    $siteId = get_current_site_id();

    $trainingSeriesReportingTable = $wpdb->get_blog_prefix($siteId) . 'training_series_reporting';
    $trainingSeriesLikesTable = $wpdb->get_blog_prefix($siteId) . 'training_series_likes';

    $likesTableSql = "SELECT id FROM `$trainingSeriesLikesTable` WHERE training_series_id=$trainingSeriesId AND user_id=$userId";
    $likesTableResult = $wpdb->get_results($likesTableSql);
    if (!empty($likesTableResult)) {
        $wpdb->delete($trainingSeriesLikesTable, ['training_series_id' => $trainingSeriesId, 'user_id' => $userId], ['%d', '%d']);

        // Check if entry exists
        $reportingCountSql = "SELECT likes FROM `$trainingSeriesReportingTable` WHERE training_series_id=$trainingSeriesId";
        $reportingCountResult = $wpdb->get_results($reportingCountSql);

        if (!empty($reportingCountResult)) {
            $likes = (int) $reportingCountResult[0]->likes - 1;

            if ($likes >= 0) {
                // Update reporting table
                $data = ['likes' => $likes];
                $where = ['training_series_id' => $trainingSeriesId];
                $wpdb->update( $trainingSeriesReportingTable, $data, $where);
            }
        }
    }

    return [];
}

/**
 * REST API Endpoint: Like training series
 */
add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v2', '/like/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'apo_training_series_like'
    ) );
});

function apo_training_series_like($data)
{
    global $wpdb;

    $trainingSeriesId = (int) $data['id'];
    $userId = get_current_user_id();
    $siteId = get_current_site_id();

    $trainingSeriesReportingTable = $wpdb->get_blog_prefix($siteId) . 'training_series_reporting';
    $trainingSeriesLikesTable = $wpdb->get_blog_prefix($siteId) . 'training_series_likes';

    $likesTableSql = "SELECT id FROM `$trainingSeriesLikesTable` WHERE training_series_id=$trainingSeriesId AND user_id=$userId";
    $likesTableResult = $wpdb->get_results($likesTableSql);
    if (empty($likesTableResult)) {
        $wpdb->insert($trainingSeriesLikesTable, array(
            'training_series_id' => $trainingSeriesId,
            'user_id' => $userId
        ));

        // Check if entry exists
        $reportingCountSql = "SELECT likes FROM `$trainingSeriesReportingTable` WHERE training_series_id=$trainingSeriesId";
        $reportingCountResult = $wpdb->get_results($reportingCountSql);

        if (empty($reportingCountResult)) {
            $wpdb->insert($trainingSeriesReportingTable, array(
                'training_series_id' => $trainingSeriesId,
                'likes' => 0
            ));
            $likes = 1;
        } else {
            $likes = (int) $reportingCountResult[0]->likes + 1;
        }

        // Update reporting table
        $data = ['likes' => $likes];
        $where = ['training_series_id' => $trainingSeriesId];
        $wpdb->update( $trainingSeriesReportingTable, $data, $where);
    }

    return [];
}

/**
 * After activate plugin
 */
register_activation_hook(__FILE__, function () {

    global $wpdb;

    $siteId = get_current_site_id();

    $trainingSeriesReportingTable = $wpdb->get_blog_prefix($siteId) . 'training_series_reporting';
    if ($wpdb->get_var("show tables like '$trainingSeriesReportingTable'") != $trainingSeriesReportingTable) {
        $sql = "CREATE TABLE `$trainingSeriesReportingTable` (";
        $sql .= " `id` int(11) NOT NULL auto_increment, ";
        $sql .= " `training_series_id` int(11) NOT NULL, ";
        $sql .= " `likes` int(11) NOT NULL DEFAULT 0, ";
        $sql .= " PRIMARY KEY (`id`) ";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=latin1;";

        require_once(ABSPATH . '/wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }

    $trainingSeriesLikesTable = $wpdb->get_blog_prefix($siteId) . 'training_series_likes';
    if ($wpdb->get_var("show tables like '$trainingSeriesLikesTable'") != $trainingSeriesLikesTable) {
        $sql = "CREATE TABLE `$trainingSeriesLikesTable` (";
        $sql .= " `id` int(11) NOT NULL auto_increment, ";
        $sql .= " `training_series_id` int(11) NOT NULL, ";
        $sql .= " `user_id` int(11) NOT NULL, ";
        $sql .= " PRIMARY KEY (`id`) ";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=latin1;";

        require_once(ABSPATH . '/wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }
});

