<?php
/**
 * Plugin Name: ApoVoice - Inactive Users
 * Plugin URI: https://www.apovoice.es
 * Description: ApoVoice - Inactive Users
 * Version: 1.3.0
 * Author: ApoVoice
 * Author URI: https://www.apovoice.es
 */

define('APOVOICE_INACTIVE_USERS_VERSION', '1.3.0');
define('APOVOICE_DELETE_USERS_AFTER_X_DAYS', 1520);
define('APOVOICE_EXPORT_USERS_AFTER_X_DAYS', 1440);

/**
 * Activate delete inactive users
 */
register_activation_hook(__FILE__, 'apo_delete_inactive_users_activation');
function apo_delete_inactive_users_activation()
{
    if (!wp_next_scheduled('apo_delete_inactivate_users')) {
        wp_schedule_event(time(), 'daily', 'apo_delete_inactivate_users');
    }
}

/**
 * Event delete inactive users
 */
add_action('apo_delete_inactivate_users', 'apo_delete_inactivate_users_exec');
function apo_delete_inactivate_users_exec()
{
    global $wpdb;

    $users = apo_get_inactive_users(APOVOICE_DELETE_USERS_AFTER_X_DAYS, true);
    foreach ($users as $user) {
        $meta = $wpdb->get_col( $wpdb->prepare( "SELECT umeta_id FROM $wpdb->usermeta WHERE user_id = %d", $user->ID ) );
        foreach ( $meta as $mid ) {
            delete_metadata_by_mid( 'user', $mid );
        }

        $wpdb->delete( $wpdb->users, array( 'ID' => $user->ID ) );
        $deletedUsers = get_option('apo_deleted_users');
        if (empty($deletedUsers)) {
            $deletedUsers = 0;
        }
        $deletedUsers++;
        update_option('apo_deleted_users', $deletedUsers);
    }
}

/**
 * Deactivate delete users
 */
register_deactivation_hook(__FILE__, 'apo_delete_inactive_users_deactivation');
function apo_delete_inactive_users_deactivation()
{
    wp_clear_scheduled_hook('apo_delete_inactivate_users');
}

/**
 * Add menu pages
 */
add_action('admin_menu', function () {

    add_menu_page('Inactive users', 'Inactive users ', 'manage_options', 'apo_inactive_users', function () {
        ?>
        <h1>Inactive users</h1>
        <p>Export all inactive users as CSV file.</p>
        <p>Total <?= count(get_users()) ?> user(s), <?= count(apo_get_inactive_users(APOVOICE_EXPORT_USERS_AFTER_X_DAYS)) ?> inactive user(s), <?= count(apo_get_inactive_users(APOVOICE_DELETE_USERS_AFTER_X_DAYS)) ?> user(s) that will be deleted, <?= get_option('apo_deleted_users') ?: 0 ?> user(s) deleted</p>
        <form method="post">
            <button type="submit" class="button button-primary button-large" name="apo_export_inactive_users">Export
                .CSV File
            </button>
        </form>
        <?php
    }, 'dashicons-download', 65);
});

/**
 * Get inactive users by min date
 * @param null $minDays
 * @param bool $object
 * @return array
 */
function apo_get_inactive_users($minDays = null, $object = false)
{
    if ($minDays === null) {
        return array();
    }

    $users = get_users();
    $inActiveUsers = [];
    foreach ($users as $user) {
        $userMeta = get_userdata($user->ID);
        $userRoles = $userMeta->roles;

        $userCreatedAt = $userMeta->data->user_registered;

        if (!in_array('administrator', $userRoles) &&
            !in_array('pg_member', $userRoles) &&
            !in_array('pg_admin', $userRoles)) {
            $lastLogin = get_user_meta($user->ID, 'last_login'); // New
            $lastLoginOld = get_user_meta($user->ID, 'login_dates', true); // Old
            if (!empty($lastLoginOld)) {
                $lastLoginOld = unserialize($lastLoginOld);
                if (!is_array($lastLoginOld)) {
                    $lastLoginOld = unserialize($lastLoginOld);
                }
                $lastLoginOld = end($lastLoginOld);
            }

            if (empty($lastLogin) && empty($lastLoginOld)) {
                $lastLoginOld = strtotime($userCreatedAt);
            }

            $time = $lastLoginOld;
            $diff = time() - $time;
            $days = round($diff / (60 * 60 * 24));

            if ($days >= $minDays) {
                if ($object) {
                    $inActiveUsers[] = $user;
                } else {
                    $inActiveUsers[] = [
                        'id' => $userMeta->data->ID,
                        'first_name' => $userMeta->first_name,
                        'last_name' => $userMeta->last_name,
                        'user_login' => $userMeta->data->user_login,
                        'user_nicename' => $userMeta->data->user_nicename,
                        'display_name' => $userMeta->data->display_name,
                        'user_email' => $userMeta->data->user_email,
                        'user_registered' => $userMeta->data->user_registered,
                        'user_status' => $userMeta->data->user_status,
                        'last_login' => $days,
                        'last_login_date' => date('Y-m-d', $lastLoginOld)
                    ];
                }
            }
        }
    }

    return $inActiveUsers;
}

/**
 * Export inactive users
 */
add_action('init', function () {
    if (is_admin() && isset($_POST['apo_export_inactive_users'])) {
        $users = apo_get_inactive_users(APOVOICE_EXPORT_USERS_AFTER_X_DAYS);
        $csv = 'ID;First name;Last name;User Login;User Nickname;Display Name;User E-Mail;Registered;Status;Last Login;Last Login Date;';
        foreach ($users as $userData) {
            $csv .= "\n" . implode(";", $userData);
        }

        $filename = 'apo_inactive_users_' . time();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv";');
        echo $csv;
        exit;
    }
});

/**
 * Set last login as user meta data
 * @param $user_login
 * @param $user
 */
function apo_user_last_login($user_login, $user)
{
    update_user_meta($user->ID, 'last_login', time());

}

add_action('wp_login', 'apo_user_last_login', 10, 2);