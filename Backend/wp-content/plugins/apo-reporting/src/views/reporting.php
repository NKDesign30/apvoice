<?php

if (!class_exists('WP_List_Table')) {
    require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Reporting_Table extends WP_List_Table
{
    private $format;

    public function __construct() {
        parent::__construct(array(
            'singular' => 'Reporting',
            'plural' => 'Reporting',
            'ajax' => false
        ));
        $this->format = get_option( 'date_format' );
    }
    public static function get_codes($per_page = 20, $page_number = 1) {
        global $wpdb;

        $where = [];

        if( isset($_REQUEST['s']) && empty( $_REQUEST['s'] ) === false ){
            $where[] = $wpdb->prepare( "`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`registered_expert_code` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`registered_pharmacy_id` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`pharmacy_unique_number` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`wp_users`.`user_email` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`wp_users`.`display_name` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
        }

        if( isset($_REQUEST['orderby']) && empty($_REQUEST['orderby']) === false ){
            $orderby = " ORDER BY `". $_REQUEST['orderby'] . "`";
        } else {
            $orderby = " ORDER BY `created_at`";
        }

        if( isset($_REQUEST['order']) && empty($_REQUEST['order']) === false ){
            $orderby .= " ". $_REQUEST['order'];
        } else {
            $orderby .= " DESC";
        }

        $sql = "SELECT
        `{$wpdb->prefix}apo_daily_stats_per_sales_rep`.*,
        (SELECT meta_value FROM wp_usermeta WHERE wp_usermeta.user_id=`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.user_id AND meta_key = 'registered_pg_customer_id') as pgci,
        (SELECT meta_value FROM wp_usermeta WHERE wp_usermeta.user_id=`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.user_id AND meta_key = 'wp_user_level') as user_level,
        (SELECT display_name FROM `wp_users` WHERE `wp_users`.ID = `{$wpdb->prefix}apo_daily_stats_per_sales_rep`.sales_rep_user_id) as sales_rep,
        `wp_users`.`ID`,
        `wp_users`.`user_email` as `user_email`,
        `wp_users`.`display_name` as `user_name`,
        (SELECT meta_value FROM wp_usermeta WHERE wp_usermeta.user_id=`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.user_id AND meta_key = 'login_dates') as last_login
    FROM
        `{$wpdb->prefix}apo_daily_stats_per_sales_rep`
        LEFT JOIN
            `wp_users`
        ON
            `wp_users`.`ID` = `{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`user_id`
    " . ( count( $where ) > 0 ? ' WHERE ' . implode( 'OR', $where ) : '' ) . $orderby;

        $sql.= " LIMIT $per_page";
        $sql.= ' OFFSET ' . ($page_number - 1) * $per_page;


        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }
    function get_columns() {
        $columns = [
            'sales_rep'              => __('Sales Rep', 'apovoice-sales-rep-email'),
            'user_name'              => __('User', 'apovoice-user-name'),
            'user_email'             => __('Email', 'apovoice-user-email'),
            'registered_expert_code'       => __('Registered Expert Code', 'apovoice-expert-code'),
            'pharmacy_unique_number'               => __('PUN', 'apovoice-pun'),
            'pgci'              => __('PGCI', 'apovoice-pgci'),
            'pharmacy_name'              => __('Pharmacy Name', 'apovoice-pgci'),
            'user_level'              => 'Level',
            'date'        => __('Updated At', 'apovoice-date'),
            'last_login'        => __('Last login', 'apovoice-login'),
        ];
        return $columns;
    }
    public function get_hidden_columns() {
        return array();
    }
    public function get_sortable_columns() {
        $sortable_columns = array(

        );
        return $sortable_columns;
    }
    public function column_default( $item, $column_name ) {


        switch ( $column_name ) {
            case "last_login":
                $dates = maybe_unserialize(maybe_unserialize($item[$column_name]));
                if(is_array($dates) && count($dates) > 0){
                    return date_i18n($this->format, $dates[count($dates)-1]);
                }else{
                    return $item[$column_name];
                }
                break;
            case "date":
                return date_i18n($this->format, strtotime($item[$column_name]));
                break;
            default:
                return $item[$column_name];
        }
    }
    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="codes[]" value="%s" />', $item['expert_code']
        );
    }
    function column_your_name( $item ) {}
    public function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    public static function delete_records($id) {}
    public static function record_count() {
        global $wpdb;

        $where = [];

        if( isset($_REQUEST['s']) && empty( $_REQUEST['s'] ) === false ){
            $where[] = $wpdb->prepare( "`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`registered_expert_code` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`registered_pharmacy_id` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`pharmacy_unique_number` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`wp_users`.`user_email` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`wp_users`.`display_name` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
        }

        $sql = "SELECT
            count(`{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`user_id`) as count
        FROM
            `{$wpdb->prefix}apo_daily_stats_per_sales_rep`
            LEFT JOIN
                `wp_users`
            ON
                `wp_users`.`ID` = `{$wpdb->prefix}apo_daily_stats_per_sales_rep`.`sales_rep_user_id`
        " . ( count( $where ) > 0 ? ' WHERE ' . implode( 'OR', $where ) : '' ) . "
        ORDER BY
            `created_at`";

        return $wpdb->get_results($sql)[0]->count;
    }
    public function no_items() {}
    public function process_bulk_action() {}
    public function prepare_items(){
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );
        $this->process_bulk_action();
        $per_page = 50;
        $current_page = $this->get_pagenum();
        $total_items = self::record_count();
        $data = self::get_codes($per_page, $current_page);
        $this->set_pagination_args( [
            'total_items' => $total_items,
            'per_page' => $per_page,
        ]);
        $this->items = $data;
    }
}

global $wpdb;

?>


<div id="reporting" class="wrap">
    <h1><?= __( 'Registered Users via Sales Reps', 'apo_reporting' ) ?></h1>
    <p><?= __( 'It deals not live data. You see all collected relevant reporting data.', 'apo_reporting' ) ?></p>
    <p><a class="exportReporting" href="reporting-export.php">Export Reporting as CSV</a></p>


        <?php 

        $Table = new Reporting_Table;
        echo '<form method="post">';
            $Table->prepare_items();
            $Table->search_box('Search ...','search_record');
            $Table->display();
            echo '</form>';
        
        ?>
</div>