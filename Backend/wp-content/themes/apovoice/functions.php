<?php

use apo\rxts\controllers\JWTAuthController;

require_once get_template_directory() . '/inc/helpers.php';

if (!function_exists('update_gform_user_ip')) {
    function update_gform_user_ip($ip)
    {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        return $ip;
    }
}
add_filter('gform_ip_address', 'update_gform_user_ip', 10, 1);

/**
 * Unregister the /wp-json/wp/v2/comments endpoint so it will not be cached.
 */
function wprc_unregister_wp_comments_endpoint($allowed_endpoints)
{
    if (isset($allowed_endpoints['wp/v2']) && ($key = array_search('users', $allowed_endpoints['wp/v2'])) !== false) {
        unset($allowed_endpoints['wp/v2'][$key]);
    }

    return $allowed_endpoints;
}
add_filter('wp_rest_cache/allowed_endpoints', 'wprc_unregister_wp_comments_endpoint', 10, 1);

/**
 * Theme setup
 */
function apo_theme_setup()
{
    global $apo_form_locations;

    $apo_form_locations = array(
        array(
            'key' => 'apo_register_form',
            'title' => __('Registration', 'apovoice'),
        ),
        array(
            'key' => 'apo_password_forgotten_form',
            'title' => __('Password forgotten', 'apovoice'),
        ),
        array(
            'key' => 'apo_reset_password_form',
            'title' =>  __('Reset password', 'apovoice'),
        ),
        array(
            'key' => 'apo_contact_form',
            'title' => __('Contact', 'apovoice'),
        ),
        array(
            'key' => 'apo_change_email_form',
            'title' => __('Change Email', 'apovoice'),
        ),
        array(
            'key' => 'apo_request_form',
            'title' => __('Request', 'apovoice'),
        ),
    );

    load_theme_textdomain('apovoice', get_template_directory() . '/languages');

    /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
    add_theme_support('title-tag');

    /*
    * Enable support for Post Thumbnails on posts and pages.
    *
    * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
    */
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1568, 9999);

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(
        array(
            'menu-1' => __('Primary', 'apovoice'),
            'footer' => __('Footer Menu', 'apovoice'),
        )
    );

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );

    // Add support for Block Styles.
    add_theme_support('wp-block-styles');

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'apo_theme_setup');


/**
 * Delete user also in gravity forms table
 */
function delete_gf_user($user_id)
{
    $user_id = get_user_by('id', $user_id)->ID;
    $search_criteria['field_filters'][] = array('key' => 'created_by', 'value' => $user_id);
    $entries = GFAPI::get_entries(2, $search_criteria);
    if ($entries) {
        foreach ($entries as $entry) {
            GFAPI::delete_entry($entry['id']);
        }
    }
}
add_action("wpmu_delete_user", "delete_gf_user");

/**
 * Enqueue scripts and styles.
 */
function apo_setup_scripts()
{
    wp_enqueue_style('apovoice-style', get_stylesheet_uri(), array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'apo_setup_scripts');

/**
 * Enqueue scripts and styles only for wp-admin.
 */
function apo_setup_admin_scripts()
{
    wp_enqueue_style('apo-admin-styles', get_stylesheet_directory_uri() . '/style-admin.css');
    wp_enqueue_script('apo-admin-scripts', get_stylesheet_directory_uri() . '/admin.js');
}
add_action('admin_enqueue_scripts', 'apo_setup_admin_scripts');

/**
 * Allow ODP Uploads
 */
function apo_allow_odp($mimes)
{
    $mimes['odp'] = 'application/vnd.oasis.opendocument.presentation';

    return $mimes;
}
add_filter('upload_mimes', 'apo_allow_odp');


/**
 * Redirect non-admin users to home page
 */
function apo_redirect_non_admin_users()
{
    if (
        (bool) !array_intersect(['administrator', 'pg_admin'], (array) wp_get_current_user()->roles) &&
        ('/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'])
    ) {
        wp_redirect(get_option('apo_frontend_url'));
        exit;
    }
}
add_action('admin_init', 'apo_redirect_non_admin_users');

/**
 * Show tools.php only for admins
 */
function apo_show_tools_only_for_admins()
{
    if (!in_array('administrator',  wp_get_current_user()->roles)) {
        remove_menu_page('tools.php');
    }
}
add_action('admin_init', 'apo_show_tools_only_for_admins');

/**
 * Adjust the lost password url to the frontend url
 */
function apo_lost_password_url()
{
    return get_option('frontend_url') . '/forgot-password';
}
add_filter('lostpassword_url',  'apo_lost_password_url', 10, 0);

if (!function_exists('apo_check_environment')) {
    function apo_check_environment($user, $username)
    {
        if (!empty($username)) {
            $data = get_user_by('email', $username) ? get_user_by('email', $username) : get_user_by('login', $username);

            if ($data) {
                $user_id = $data->ID;
                $primary_blog_id = get_user_meta($user_id, 'primary_blog', true);
                $current_blog_id = get_current_blog_id();
                $user_is_admin = !empty(user_can($user_id, 'administrator'));

                if (($primary_blog_id != $current_blog_id) && !$user_is_admin) {
                    return new WP_Error('wrong_environment', __('Login failed. Sure you`re in the right country?', 'apovoice'));
                }
            }
        }

        return $user;
    }
}
add_filter('authenticate', 'apo_check_environment', 100, 2);

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/token/refresh', array(
        'methods' => 'GET',
        'callback' => [new JWTAuthController, 'refresh'],
        'permission_callback' => '__return_true'
    ));
});

add_filter('gform_validation', function ($validation_result) {
    $form = $validation_result['form'];

    $isValidStatus = true;
    foreach ($form['fields'] as &$field) {
        if ($field->id == '1' ||  $field->id == '2') {
            $field->failed_validation = false;
        } else if ($field->failed_validation == true) {
            $isValidStatus = false;
        }
    }

    $validation_result['is_valid'] = $isValidStatus;

    $validation_result['form'] = $form;
    return $validation_result;
}, 50, 2);

add_filter('gform_validation', function ($validation_result) {
    $form = $validation_result['form'];

    $isValidStatus = true;
    foreach ($form['fields'] as &$field) {
        if ($field->id == '1' ||  $field->id == '2') {
            $field->failed_validation = false;
        } else if ($field->failed_validation == true) {
            $isValidStatus = false;
        }
    }

    $validation_result['is_valid'] = $isValidStatus;

    $validation_result['form'] = $form;
    return $validation_result;
}, 50, 2);



/**
 * Gravity-Forms customization
 */
require_once get_template_directory() . '/inc/gravity-forms/gravity-forms-customs.php';

/**
 * Settingspage for the frontend
 */
require_once get_template_directory() . '/inc/frontend-settings.php';

/**
 * User profile settings
 */
require_once get_template_directory() . '/inc/user-profile.php';

/**
 * User profile settings
 */
require_once get_template_directory() . '/inc/pending-redemers.php';

/**
 * User profile settings
 */
require_once get_template_directory() . '/inc/accepted-newsletter.php';


require_once get_template_directory() . '/inc/expert-points.php';

/** 
 * Delete user from signups table as well if exists
 */

function custom_remove_user($user_id)
{
    global $wpdb;
    $user_email = get_userdata($user_id)->user_email;

    $wpdb->get_results("DELETE FROM wp_signups WHERE user_email = '" . $user_email . "'");
}

add_action('wp_delete_user', 'custom_remove_user', 10);
add_action('wpmu_delete_user', 'custom_remove_user', 10);

add_action('load-edit.php', function () {
    $screen = get_current_screen();
    // Only edit post screen:
    if ('edit-trainings' === $screen->id) {
        // Before:  
        add_action('all_admin_notices', function () {
            echo '<p><a href="training-export.php">Export Training Key Questions</a></p>';
        });
    }
});

function apo_enable_output_buffering_on_login()
{
    ob_start();
}
add_action('login_init', 'apo_enable_output_buffering_on_login');

function apo_add_autocomplete_attributes_tologin_form()
{
    $content = ob_get_contents();
    ob_end_clean();

    $content = str_replace('id="loginform"', 'id="loginform" autocomplete="off"', $content);
    $content = str_replace('id="user_login"', 'id="user_login" autocomplete="off"', $content);
    $content = str_replace('id="user_pass"', 'id="user_pass" autocomplete="off"', $content);

    echo $content;
}
add_action('login_form', 'apo_add_autocomplete_attributes_tologin_form');

/**
 * Populate ACF select field options with Gravity Forms forms.
 */
function apo_populate_gravity_form_ids_to_acf($field)
{
    if (class_exists('GFFormsModel')) {
        $field['required'] = true;
        $choices = [];
        foreach (\GFFormsModel::get_forms() as $form) {
            $choices[$form->id] = $form->title;
        }
        $field['choices'] = $choices;
    }

    return $field;
}
add_filter('acf/load_field/name=gravity_form_id', 'apo_populate_gravity_form_ids_to_acf');

add_filter('gform_notification_events', 'gw_add_manual_notification_event');
function gw_add_manual_notification_event($events)
{
    $events['manual'] = __('Send Manually');
    return $events;
}


@ini_set('upload_max_size', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300');

// These filters are only for restrictive login bound to client ip
// add_filter( 'allowed_http_origins', 'add_allowed_origins' );
// function add_allowed_origins( $origins ) {
//     $origins[] = 'http://45.9.191.59';
//     $origins[] = 'http://45.9.191.59:8000';
//     return $origins;
// }

// add_filter('rest_authentication_errors', 'rest_filter_incoming_connections');
// function rest_filter_incoming_connections($errors) {
//     $request_server = $_SERVER['REMOTE_ADDR'];
//     $origin = get_http_origin();
//     if ($origin !== 'http://45.9.191.59:8000') return new WP_Error('forbidden_access', $origin, array(
//          'status' => 403
//     ));
//     return $errors;
// }

// Hook.
add_action('rest_api_init', 'wp_rest_allow_all_cors', 15);

/**
 * Allow all CORS.
 *
 * @since 1.0.0
 */
function wp_rest_allow_all_cors()
{
    // Remove the default filter.
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');

    // Add a Custom filter.
    add_filter('rest_pre_serve_request', function ($value) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: *');
        return $value;
    });
}

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/latest-surveys/', array(
        'methods' => 'GET',
        'callback' => 'get_latest_surveys'
    ));
});

function get_latest_surveys()
{
    global $wpdb;

    $USER_ID = get_current_user_id();
    $site_id = get_current_site_id();
    $surveys_user_results_table = $wpdb->get_blog_prefix($site_id) . 'survey_user_results';


    $training_user_results_table = $wpdb->get_blog_prefix($site_id) . 'training_user_results';
    $Completed_training_sql = "SELECT training_id FROM `$training_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_training_data = $wpdb->get_results($Completed_training_sql);

    $args = array(
        'post_type' => 'surveys',
        'posts_per_page' => '10',
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'ID'
    );
    switch_to_blog($site_id);
    $posts = get_posts($args);
    restore_current_blog();

    $Completed_survey_sql = "SELECT survey_id FROM `$surveys_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_survey_data = $wpdb->get_results($Completed_survey_sql);
    $Completed_survey_ids = array();
    foreach ($Completed_survey_data as $row) {
        array_push($Completed_survey_ids, $row->survey_id);
    }

    if ($posts) {
        $surveys = array();
        foreach ($posts as $post) {
            $maxUsers = (int) get_field('max_users', $post->ID);
            $user_competed_sql = "SELECT count(id) as complete FROM `$surveys_user_results_table` WHERE  survey_id=$post->ID and is_complete =1";
            $user_competed_result = $wpdb->get_results($user_competed_sql);
            $user_competed = (int)$user_competed_result[0]->complete;

            if ($user_competed <= $maxUsers) {
                $surveys[] = [
                    'id' => $post->ID,
                    'title' => array('rendered' => $post->post_title),
                    'fields' => get_fields($post->ID),
                    'is_complete' => (int) in_array($post->ID, $Completed_survey_ids)
                ];
            }
        }
    }

    if (!empty($surveys)) {
        $newsurveys = [];
        $arr = [];
        $myarray = [];
        foreach ($Completed_training_data as $item) {
            array_push($arr, $item->training_id);
        }

        foreach ($surveys as $value) {
            //training activable relation
            $acf = $value['fields']['training_relation'];
            if ($acf['activatable']) {
                array_push($myarray, 1);
                if (in_array($acf['training'], $arr)) {
                    array_push($newsurveys, $value);
                }
            } else {
                array_push($newsurveys, $value);
            }
        }
        return $newsurveys;
    } else {
        return  [];
    }
}

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/latest-training-series-premium/', array(
        'methods' => 'GET',
        'callback' => 'latestTrainingSeriesPremium'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/training-category-series', array(
        'methods' => 'GET',
        'callback' => 'latestCategoryTrainingSeries'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/training-product-series', array(
        'methods' => 'GET',
        'callback' => 'trainingProductSeries'
    ));
});

function trainingProductSeries()
{
    return custom_training_max_user(4, 'products', false);
}

function latestCategoryTrainingSeries()
{
    return custom_training_max_user(4, "category", false);
}

function latestTrainingSeriesPremium()
{
    return custom_training_max_user(4);
}

function trainingSeriesPremium()
{
    return custom_training_max_user(100, false, true);
}

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/training-series-premium', array(
        'methods' => 'GET',
        'callback' => 'trainingSeriesPremium'
    ));
});

function custom_training_max_user($limit = 100, $onlyCategory = false, $onlyPremium = true)
{
    global $wpdb;

    $site_id = get_current_site_id();
    $USER_ID = get_current_user_id();

    //$training_user_results_table = $wpdb->get_blog_prefix($site_id).'training_user_results';
    $apo_points_table = $wpdb->get_blog_prefix($site_id) . 'apo_points';
    $trainings_user_results_table = $wpdb->get_blog_prefix($site_id) . 'training_user_results';
    $USER_ID = get_current_user_id();
    switch_to_blog($site_id);

    $dbPrefix = $wpdb->get_blog_prefix($site_id);

    if ($onlyPremium) {
        $rows = $wpdb->get_col($wpdb->prepare(
            "SELECT DISTINCT p.ID FROM " . $dbPrefix . "posts as p
            WHERE 
            p.post_status = 'publish' AND
            p.post_type = 'training-series' AND
            p.is_premium = 1"
        ));
    } elseif ($onlyCategory) {
        $rows = $wpdb->get_col($wpdb->prepare(
            "SELECT DISTINCT p.ID FROM " . $dbPrefix . "posts as p
            LEFT JOIN " . $dbPrefix . "term_relationships AS tr ON (p.ID = tr.object_id)
            LEFT JOIN " . $dbPrefix . "term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
            LEFT JOIN " . $dbPrefix . "terms AS t ON (t.term_id = tt.term_id)
            WHERE 
            p.post_status = 'publish' AND
            p.post_type = 'training-series' AND
            t.slug = '" . $onlyCategory . "' AND
            p.is_premium = 0"
        ));
    } else {
        $rows = $wpdb->get_col($wpdb->prepare(
            "SELECT DISTINCT p.ID FROM " . $dbPrefix . "posts as p
            INNER JOIN " . $dbPrefix . "term_relationships AS tr ON (p.ID = tr.object_id)
            INNER JOIN " . $dbPrefix . "term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
            INNER JOIN " . $dbPrefix . "terms AS t ON (t.term_id = tt.term_id)
            WHERE 
            p.post_status = 'publish' AND
            p.post_type = 'training-series' AND
            (t.slug = 'product' or t.slug = 'pghealth') AND
            p.is_premium = 0"
        ));
    }


    restore_current_blog();

    $Completed_training_sql = "SELECT training_id FROM `$trainings_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_training_data = $wpdb->get_results($Completed_training_sql);
    $Completed_training_ids = array();
    foreach ($Completed_training_data as $row) {
        array_push($Completed_training_ids, $row->training_id);
    }

    if (!empty($rows)) {
        $training = array();
        $i = 0;
        foreach ($rows as $postId) {
            array_push($training, $postId);
            $i++;
        }
        if (!empty($training)) {
            $request = new WP_REST_Request('GET', '/wp/v2/training-series');
            $request->set_query_params(['per_page' => $limit, 'include' => $training]);
            $response = rest_do_request($request);
            $server = rest_get_server();
            $data = $server->response_to_data($response, false);
            $result = array();
            foreach ($data as $item) {
                $isUnlocked = 0;

                $check_already_unlocked_sql = "SELECT * FROM $apo_points_table WHERE user_id = $USER_ID AND related_id=" . $item['id'];
                $wpdb->get_results($check_already_unlocked_sql);

                if ($wpdb->num_rows > 0) {
                    $isUnlocked = 1;
                }

                $item['unlocked'] = $isUnlocked;
                $item['is_complete'] = (int) in_array($item['id'], $Completed_training_ids);

                if (isset($item['trainings']) && count($item['trainings']) > 0) {
                    $result[] = $item;
                }
            }
            return $result;
        } else {
            return  [];
        }
    } else {
        return  [];
    }
}


add_action('rest_api_init', function () {
    register_rest_route('wc/v2', 'unlock-premium-training/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'validate_apo_points'
    ));
});

function validate_apo_points($data)
{
    global $wpdb;
    $training_series_id = (int) $data['id'];
    $USER_ID = get_current_user_id();

    $site_id = get_current_site_id();
    $apo_points_table = $wpdb->get_blog_prefix($site_id) . 'apo_points';

    $informations = get_field('informations', $training_series_id);
    $deduct_apo_points = (int) $informations['apo_points'];

    $available_apo_points_sql = "SELECT SUM(points_earned) as apopoints FROM $apo_points_table WHERE user_id= $USER_ID";
    $available_apo_points = $wpdb->get_results($available_apo_points_sql)[0]->apopoints;

    $check_already_unlocked_sql = "SELECT * FROM $apo_points_table WHERE user_id = $USER_ID AND related_id=$training_series_id";
    $wpdb->get_results($check_already_unlocked_sql);

    if ($wpdb->num_rows == 0) {
        if ($available_apo_points >= $deduct_apo_points) {
            $wpdb->insert($apo_points_table, array(
                'user_id'       => $USER_ID,
                'points_earned' => $deduct_apo_points > 0 ? ($deduct_apo_points * -1) : $deduct_apo_points,
                'related_type'  => 'training-series',
                'related_id'    => $training_series_id
            ));
            return true;
        } else {
            return array('Not Enough Apo Points');
        }
    } else {
        return array('Already Unlocked');
    }
}


add_action('rest_api_init', function () {
    register_rest_route('wc/v2', 'incomplete_training/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'latest_incomplete_training'
    ));
});


function latest_incomplete_training($data)
{

    $IS_PREMIUM = (int) $data['id'];
    global $wpdb;

    $site_id = get_current_site_id();

    $posts_table = $wpdb->get_blog_prefix($site_id) . 'posts';
    $training_user_results_table = $wpdb->get_blog_prefix($site_id) . 'training_user_results';

    $premium_training_series_sql = "SELECT ID FROM $posts_table WHERE post_type='training-series' AND is_premium=$IS_PREMIUM ORDER BY ID DESC";
    $premium_training_series = $wpdb->get_results($premium_training_series_sql);

    if (empty($premium_training_series)) {
        return [];
    } else {
        $Incomplete_Premium_Training = array();
        foreach ($premium_training_series as $training_series_post) {

            $acf_training = get_field('trainings', $training_series_post->ID)[0];
            $training_id = $acf_training['training_id'];

            $USER_ID = get_current_user_id();
            $Completed_training_sql = "SELECT training_id FROM `$training_user_results_table` WHERE training_id = $training_id AND user_id = $USER_ID AND is_complete=1";

            $Completed_training = $wpdb->get_results($Completed_training_sql);


            if (empty($Completed_training))  //  if Record exists means trainning completed. To return Incomplete Training  create list of not existing id
            {
                array_push($Incomplete_Premium_Training, $training_series_post->ID);
            }
        }


        if (empty($Incomplete_Premium_Training)) {
            return [];
        } else {
            $Incomplete_training_id = implode(',', $Incomplete_Premium_Training);

            $request = new WP_REST_Request('GET', '/wp/v2/training-series');
            $request->set_query_params(['per_page' => 4, 'include' => $Incomplete_training_id]);
            $response = rest_do_request($request);
            $server = rest_get_server();
            $data = $server->response_to_data($response, false);
            return $data;
        }
    }
}

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/count_overview', array(
        'methods' => 'GET',
        'callback' => 'count_overview'
    ));
});


function count_overview()
{
    global $wpdb;

    $site_id = get_current_site_id();
    $posts_table = $wpdb->get_blog_prefix($site_id) . 'posts';
    $USER_ID = get_current_user_id();

    // Count training
    $training_user_results_table = $wpdb->get_blog_prefix($site_id) . 'training_user_results';

    $Completed_training_sql = "SELECT count(training_id) AS COMPLETED FROM `$training_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_training_data = $wpdb->get_results($Completed_training_sql);

    $Completed_training = $Completed_training_data[0]->COMPLETED;

    $Total_trainings_sql = "SELECT count(ID) as TOTAL from $posts_table WHERE post_type='trainings'";
    $Total_training_data = $wpdb->get_results($Total_trainings_sql);

    $Total_training = $Total_training_data[0]->TOTAL;
    $Incomplete_training = $Total_training - $Completed_training;

    // Count surveys
    $survey_user_results_table = $wpdb->get_blog_prefix($site_id) . 'survey_user_results';

    $Completed_survey_sql = "SELECT count(training_id) AS COMPLETED FROM `$survey_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_survey_data = $wpdb->get_results($Completed_survey_sql);

    $Completed_survey = $Completed_survey_data[0]->COMPLETED;

    $Total_survey_sql = "SELECT count(ID) as TOTAL from $posts_table WHERE post_type='surveys'";
    $Total_survey_data = $wpdb->get_results($Total_survey_sql);

    $Total_survey = $Total_survey_data[0]->TOTAL;
    $Incomplete_survey = $Total_survey - $Completed_survey;

    return array(
        'training_complete' => (int) $Completed_training,
        'training_incomplete' => $Incomplete_training,
        'survey_complete' => (int) $Completed_survey,
        'survey_incomplete' => (int) $Incomplete_survey,
    );
}


add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/count_overview_training', array(
        'methods' => 'GET',
        'callback' => 'count_overview_training'
    ));
});


function count_overview_training()
{
    global $wpdb;

    $site_id = get_current_site_id();
    $training_user_results_table = $wpdb->get_blog_prefix($site_id) . 'training_user_results';
    $posts_table = $wpdb->get_blog_prefix($site_id) . 'posts';

    $USER_ID = get_current_user_id();
    $Completed_training_sql = "SELECT count(training_id) AS COMPLETED FROM `$training_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_training_data = $wpdb->get_results($Completed_training_sql);

    $Completed_training = $Completed_training_data[0]->COMPLETED;

    $Total_trainings_sql = "SELECT count(ID) as TOTAL from $posts_table WHERE post_type='trainings'";
    $Total_training_data = $wpdb->get_results($Total_trainings_sql);

    $Total_training = $Total_training_data[0]->TOTAL;
    $Incomplete_training = $Total_training - $Completed_training;


    $overview['complete'] = (int) $Completed_training;
    $overview['incomplete'] = $Incomplete_training;

    return $overview;
}


add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/incomplete_survey', array(
        'methods' => 'GET',
        'callback' => 'incomplete_survey'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/surveys_filtered', array(
        'methods' => 'GET',
        'callback' => 'surveys_filtered'
    ));
});


function incomplete_survey()
{
    global $wpdb;

    $USER_ID = get_current_user_id();
    $training_user_results_table = $wpdb->get_blog_prefix($site_id) . 'training_user_results';
    $Completed_training_sql = "SELECT training_id FROM `$training_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_training_data = $wpdb->get_results($Completed_training_sql);
    $site_id = get_current_site_id();
    $surveys_user_results_table = $wpdb->get_blog_prefix($site_id) . 'survey_user_results';

    $args = array(
        'post_type' => 'surveys',
        'posts_per_page' => '20',
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'ID'
    );
    switch_to_blog($site_id);
    $posts = get_posts($args);
    restore_current_blog();

    $Completed_survey_sql = "SELECT survey_id FROM `$surveys_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_survey_data = $wpdb->get_results($Completed_survey_sql);
    $Completed_survey_ids = array();
    foreach ($Completed_survey_data as $row) {
        array_push($Completed_survey_ids, $row->survey_id);
    }

    $excludeIds = [];
    if ($posts) {
        $surveys = array();
        foreach ($posts as $post) {
            $expiresAT = get_field('expires_at', $post->ID);
            $today = date('Y-m-d');
            if ($expiresAT < $today) {
                array_push($excludeIds, $post->ID);
            }
            $maxUsers = (int) get_field('max_users', $post->ID);
            $user_competed_sql = "SELECT count(id) as complete FROM `$surveys_user_results_table` WHERE  survey_id=$post->ID and is_complete =1";
            $user_competed_result = $wpdb->get_results($user_competed_sql);
            $user_competed = (int)$user_competed_result[0]->complete;

            if ($user_competed >= $maxUsers && !in_array($post->ID, $Completed_survey_ids)) {
                array_push($excludeIds, $post->ID);
            }
        }
    }

    $request = new WP_REST_Request('GET', '/wp/v2/surveys');
    $request->set_query_params(['per_page' => 20, 'exclude' => $excludeIds]);
    $response = rest_do_request($request);
    $server = rest_get_server();
    $data = $server->response_to_data($response, false);

    $newdata = [];
    $arr = [];
    $myarray = [];
    foreach ($Completed_training_data as $item) {
        array_push($arr, $item->training_id);
    }

    foreach ($data as $value) {
        //training activable relation
        $acf = $value['acf']['training_relation'];
        if ($acf['activatable']) {
            array_push($myarray, 1);
            if (in_array($acf['training'], $arr)) {
                array_push($newdata, $value);
            }
        } else {
            array_push($newdata, $value);
        }
        //  }
    }

    return $newdata;
}


function surveys_filtered()
{
    global $wpdb;

    $USER_ID = get_current_user_id();
    $site_id = get_current_site_id();
    $surveys_user_results_table = $wpdb->get_blog_prefix($site_id) . 'survey_user_results';

    $args = array(
        'post_type' => 'surveys',
        'posts_per_page' => '20',
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'ID'
    );
    switch_to_blog($site_id);
    $posts = get_posts($args);
    restore_current_blog();

    $Completed_survey_sql = "SELECT survey_id FROM `$surveys_user_results_table` WHERE user_id = $USER_ID and is_complete=1";
    $Completed_survey_data = $wpdb->get_results($Completed_survey_sql);
    $Completed_survey_ids = array();
    foreach ($Completed_survey_data as $row) {
        array_push($Completed_survey_ids, $row->survey_id);
    }


    $excludeIds = [];
    if ($posts) {
        $surveys = array();
        foreach ($posts as $post) {
            $maxUsers = (int) get_field('max_users', $post->ID);
            $expiresAT = get_field('expires_at', $post->ID);
            $today = date('Y-m-d');
            if ($expiresAT < $today) {
                array_push($excludeIds, $post->ID);
            }
            $user_competed_sql = "SELECT count(id) as complete FROM `$surveys_user_results_table` WHERE  survey_id=$post->ID and is_complete =1";
            $user_competed_result = $wpdb->get_results($user_competed_sql);
            $user_competed = (int)$user_competed_result[0]->complete;

            if ($user_competed >= $maxUsers && !in_array($post->ID, $Completed_survey_ids)) {
                array_push($excludeIds, $post->ID);
            }
        }
    }

    $request = new WP_REST_Request('GET', '/wp/v2/surveys');
    $request->set_query_params(['per_page' => 20, 'exclude' => $excludeIds]);
    $response = rest_do_request($request);
    $server = rest_get_server();
    $data = $server->response_to_data($response, false);
    return $data;
}

function get_current_site_id()
{
    global $wpdb;

    $b_id =  get_current_blog_id();
    $PORT = $_SERVER['SERVER_PORT'];
    if (!empty($PORT)) {
        if ($PORT == '85') {
            $b_id = 2;
        } else if ($PORT == '90') {
            $b_id = 3;
        } else if ($PORT == '95') {
            $b_id = 4;
        }
    }
    return $b_id;
}

add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/count_overview_achievement', array(
        'methods' => 'GET',
        'callback' => 'count_overview_achievement'
    ));
});

function count_overview_achievement()
{
    global $wpdb;
    $USER_ID = get_current_user_id();

    $site_id = get_current_site_id();
    $expert_points_table = $wpdb->get_blog_prefix($site_id) . 'expert_points';

    $available_points_sql = "SELECT SUM(points_earned) as coins FROM $expert_points_table WHERE user_id= $USER_ID";
    $available_coins = $wpdb->get_results($available_points_sql)[0]->coins;

    $apo_points_table = $wpdb->get_blog_prefix($site_id) . 'apo_points';

    $available_apo_points_sql = "SELECT SUM(points_earned) as apopoints FROM $apo_points_table WHERE user_id= $USER_ID";
    $available_apo_points = $wpdb->get_results($available_apo_points_sql)[0]->apopoints;

    if (is_null($available_apo_points) or empty($available_apo_points)) {
        $available_apo_points = 0;
    }
    if (is_null($available_coins) or empty($available_coins)) {
        $available_coins = 0;
    }

    $users_remaining_point['apocoins'] = (int)$available_coins;
    $users_remaining_point['apopoints'] = (int)$available_apo_points;

    return $users_remaining_point;
}



add_action('rest_api_init', function () {
    register_rest_route('wc/v2', '/custom-training-series/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'custom_training_series_with_max_user_and_expiry_date_limit',
        'permission_callback' => '__return_true'
    ));
});
function custom_training_series_with_max_user_and_expiry_date_limit($data)
{
    global $wpdb;

    $IS_PREMIUM = (int) $data['id'];
    $site_id = get_current_site_id();
    $training_user_results_table = $wpdb->get_blog_prefix($site_id) . 'training_user_results';

    $args = array(
        'post_type' => 'training-series',
        'posts_per_page' => '-1',
        'meta_query' => array(
            array(
                'key' => 'informations_expires_at',
                'value' => date('Ymd'),
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    );
    switch_to_blog($site_id);
    $posts = get_posts($args);
    restore_current_blog();

    $k = 0;
    foreach ($posts as $row) {
        if ($row->is_premium != $IS_PREMIUM) {
            unset($posts[$k]);
        }
        $k++;
    }
    if ($posts) {
        $training = array();
        foreach ($posts as $post) {
            $informations = get_field('informations', $post->ID);
            $acf_training = get_field('trainings', $post->ID)[0];
            $training_id = $acf_training['training_id'];

            $user_competed_sql = "SELECT count(id) as complete FROM `$training_user_results_table` WHERE  training_id=$training_id and is_complete =1";
            $user_competed_result = $wpdb->get_results($user_competed_sql);
            $user_competed = (int)$user_competed_result[0]->complete;
            $max_user = (int)$informations['max_user'];
            if ($user_competed <= $max_user) {
                array_push($training, $post->ID); // Push training series ID that do not exceed max user limit
            }
        }
        if (!empty($training)) {

            $request = new WP_REST_Request('GET', '/wp/v2/training-series');
            $request->set_query_params(['per_page' => 100, 'include' => $training]);
            $response = rest_do_request($request);
            $server = rest_get_server();
            $data = $server->response_to_data($response, false);
            return $data;
        } else {
            return [];
        }
    } else {
        return  [];
    }
}



function punCodeFr()
{
    global $wpdb;
    $USER_ID = get_current_user_id();
    $punCode = $wpdb->get_results("SELECT * FROM `wp_apovoice_pharmacy_user` WHERE user_id = '$USER_ID'  ");
    $pharmacyId = $punCode[0]->pharmacy_id;
    $pharmacyUniqueNumber = $wpdb->get_results("SELECT * FROM `wp_apovoice_pharmacies` WHERE id = '$pharmacyId'  ");
    //return $pharmacyUniqueNumber[0]->pharmacy_unique_number;
    return $pharmacyUniqueNumber[0];
}
add_action('rest_api_init', function () {
    register_rest_route('apovoice/v1', 'punCode', [
        'methods' => 'GET',
        'callback' => 'punCodeFr',
    ]);
});


function update_user_pun($request)
{
    global $wpdb;
    $PunCode = $request->get_param('PunCode');
    $USER_ID = get_current_user_id();
    $result = $wpdb->get_results("SELECT * FROM `wp_apovoice_pharmacies` WHERE pharmacy_unique_number = '$PunCode'  ");
    if (!empty($result)) {
        //return($result[0]->id);
        $id = $result[0]->id;
        // $wpdb->query($wpdb->prepare("UPDATE `wp_apovoice_pharmacy_user` SET pharmacy_id=$id WHERE user_id = $user->ID"));
        $rows_affected = $wpdb->query(
            $wpdb->prepare("UPDATE `wp_apovoice_pharmacy_user` SET pharmacy_id='$id' WHERE user_id = '$USER_ID'")
        ); // $wpdb->query
        update_user_meta($USER_ID, 'registered_pharmacy_unique_number', $id);
        return ($result[0]);
    } else {
        return ("empty_data");
    }
}
add_action('rest_api_init', function () {
    register_rest_route('apovoice/v1', 'UpdatePun', [
        'methods' => 'POST',
        'callback' => 'update_user_pun',
    ]);
});

/*
add_filter('gform_confirmation', 'post_to_third_party', 10, 3);
function post_to_third_party($confirmation, $form, $entry)
{

    var_dump($entry);
    $wpdb->insert("wp_apovoice_roles", array('name' => "test"));
    // $pun=rgar( $entry, '1.3' );


    return $confirmation;
}

*/

add_action('gform_activate_user', 'after_user_activate', 10, 3);
function after_user_activate($user_id, $user_data, $signup_meta)
{
    global $wpdb;
    $site_id = get_current_site_id();

    if ($wpdb->get_blog_prefix($site_id) == "wp") {
        //get pharmacy id
        $sql = "SELECT * FROM wp_apovoice_pharmacy_user WHERE user_id = '$user_id'";
        $pharmacyId = $wpdb->get_results($sql);
        $ID = $pharmacyId[0]->pharmacy_id;
        $wpdb->insert("wp_apovoice_roles", array('name' => $ID));

        //get role linked to the selected pharmacy
        $sql2 = "SELECT r.name FROM wp_apovoice_pharmacies as p , wp_apovoice_roles as r WHERE r.id=p.role_id and p.id='$ID'";
        $role = $wpdb->get_results($sql2);


        //update user role
        $u = new WP_User($user_id);
        $u->set_role(strtolower($role[0]->name));
    }
}
//User Name
function gf_ms_get_unique_username($username)
{
    $number = 2;
    $original_username = $username;

    while (username_exists($username) || gf_ms_signup_exists($username)) {
        $username = $original_username . $number++;
    }

    return $username;
}

function gf_ms_signup_exists($username)
{
    global $wpdb;

    return $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $wpdb->signups WHERE user_login = %s",
            $username
        )
    );
}

function gf_ms_get_unique_username_callback($username, $feed, $form, $entry)
{
    $first_name = rgar($entry, rgars($feed, 'meta/first_name'));
    $last_name  = rgar($entry, rgars($feed, 'meta/last_name'));

    $new_username = gf_ms_get_unique_username(sanitize_user($first_name . $last_name));

    if (!empty($new_username)) {
        $username = $new_username;
    }

    return $username;
}

add_filter('gform_username', 'gf_ms_get_unique_username_callback', 10, 4);
