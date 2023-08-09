<?php

use apo\expertcodes\roles\ExpertCodeManagerRole;


if (!class_exists('WP_List_Table')) {
    require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Expert_Code_Table extends WP_List_Table
{
    public function __construct() {
        parent::__construct(array(
            'singular' => 'Expert Codes',
            'plural' => 'Expert Codes',
            'ajax' => false
        ));
    }
    public static function get_codes($per_page = 20, $page_number = 1) {
        global $wpdb;

        $where = [];

        if( isset($_REQUEST['s']) && empty( $_REQUEST['s'] ) === false ){
            $where[] = $wpdb->prepare( "`{$wpdb->prefix}expert_codes`.`expert_code` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
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
        `{$wpdb->prefix}expert_codes`.*,
        `wp_users`.`ID` as `sales_rep_id`,
        `wp_users`.`user_email` as `sales_rep_email`,
        `wp_users`.`display_name` as `sales_rep_name`
    FROM
        `{$wpdb->prefix}expert_codes`
        LEFT JOIN
            `wp_users`
        ON
            `wp_users`.`ID` = `{$wpdb->prefix}expert_codes`.`sales_rep_user_id`
    " . ( count( $where ) > 0 ? ' WHERE ' . implode( 'OR', $where ) : '' ) . $orderby;

        $sql.= " LIMIT $per_page";
        $sql.= ' OFFSET ' . ($page_number - 1) * $per_page;
        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }
    function get_columns() {
        $columns = [
            'cb'                => '<input type="checkbox" />',
            'expert_code'       => __('Expert Code', 'apovoice-expert-codes'),
            'sales_rep_email'   => __('Sales Rep Email', 'apovoice-expert-codes'),
            'sales_rep_name'    => __('Sales Rep Name', 'apovoice-expert-codes'),
            'usages'            => __('Usages', 'apovoice-expert-codes'),
            'used'              => __('Used', 'apovoice-expert-codes'),
            'created_at'        => __('Created At', 'apovoice-expert-codes'),
            'updated_at'        => __('Updated At', 'apovoice-expert-codes'),
        ];
        return $columns;
    }
    public function get_hidden_columns() {
        return array();
    }
    public function get_sortable_columns() {
        $sortable_columns = array(
            'expert_code'  => array('expert_code',false),
            'sales_rep_email'  => array('sales_rep_email',false),
            'sales_rep_name'  => array('sales_rep_name',false),
            'usages'  => array('usages',false),
            'used'  => array('used',false),
            'created_at'  => array('created_at',false),
            'updated_at'  => array('updated_at',false),

        );
        return $sortable_columns;
    }
    public function column_default( $item, $column_name ) {




        switch ( $column_name ) {
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
            $where[] = $wpdb->prepare( "`{$wpdb->prefix}expert_codes`.`expert_code` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`wp_users`.`user_email` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
            $where[] = $wpdb->prepare( "`wp_users`.`display_name` LIKE %s", '%' . $wpdb->esc_like( $_POST['s'] ) . '%' );
        }

        $sql = "SELECT
            `{$wpdb->prefix}expert_codes`.*,
            `wp_users`.`ID` as `sales_rep_id`,
            `wp_users`.`user_email` as `sales_rep_email`,
            `wp_users`.`display_name` as `sales_rep_name`
        FROM
            `{$wpdb->prefix}expert_codes`
            LEFT JOIN
                `wp_users`
            ON
                `wp_users`.`ID` = `{$wpdb->prefix}expert_codes`.`sales_rep_user_id`
        " . ( count( $where ) > 0 ? ' WHERE ' . implode( 'OR', $where ) : '' ) . "
        ORDER BY
            `created_at`";

        return count($wpdb->get_results($sql));
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

$canManage = current_user_can( ExpertCodeManagerRole::MANAGE_CAPABILITY );

$payload = unserialize( base64_decode( $_GET['payload'] ?? '' ) );
$payload = $payload ? $payload : [];

$messageClasses = [
    'infos' => 'updated notice',
    'errors' => 'error notice',
    'notices' => 'update-nag notice',
];
//
//$where = [];
//
//
//if ( ( $searchParam = $_GET['s'] ?? false ) ) {
//    $where[] = $wpdb->prepare( "`{$wpdb->prefix}expert_codes`.`expert_code` LIKE %s", '%' . $wpdb->esc_like( $searchParam ) . '%' );
//    $where[] = $wpdb->prepare( "`wp_users`.`user_email` LIKE %s", '%' . $wpdb->esc_like( $searchParam ) . '%' );
//    $where[] = $wpdb->prepare( "`wp_users`.`display_name` LIKE %s", '%' . $wpdb->esc_like( $searchParam ) . '%' );
//}
//
//
//$expertCodes = $wpdb->get_results( "
//    SELECT
//        `{$wpdb->prefix}expert_codes`.*,
//        `wp_users`.`ID` as `sales_rep_id`,
//        `wp_users`.`user_email` as `sales_rep_email`,
//        `wp_users`.`display_name` as `sales_rep_name`
//    FROM
//        `{$wpdb->prefix}expert_codes`
//        LEFT JOIN
//            `wp_users`
//        ON
//            `wp_users`.`ID` = `{$wpdb->prefix}expert_codes`.`sales_rep_user_id`
//    " . ( count( $where ) > 0 ? ' WHERE ' . implode( 'OR', $where ) : '' ) . "
//    ORDER BY
//        `created_at`
//" );
//
//$dateFormat = get_option( 'date_format' );
//$timeFormat = get_option( 'time_format' );

?>

<div
    id="expert-codes-app"
    class="wrap"
>
    <h1><?= __( 'Manage Apovoice Expert Codes', 'apovoice-expert-codes' ) ?></h1>

    <?php foreach ( $messageClasses as $key => $classes ): ?>
        <?php if ( array_key_exists( $key, $payload ) ): ?>
            <?php foreach ( $payload[$key] as $message ): ?>
                <div class="<?= $classes ?>">
                    <p><?= $message ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ( $canManage ) : ?>
    <form
        method="post"
        action="<?= esc_html( admin_url( 'admin-post.php' ) ) ?>"
        enctype="multipart/form-data"
    >
        <h3><?= __( 'Import an Excel Spreadsheet (.xls, .xlsx) or Comma Separated Value (.csv) File', 'apo-expert-codes' ) ?></h3>

        <input
            accept=".xls,.xlsx,.csv"
            name="apo_expertcodes_file"
            type="file"
        >
        <input type="hidden" name="action" value="apo_expertcodes_form">

        <?php wp_nonce_field( 'apo_expertcodes_save_settings', 'apo_expertcodes_save_settings_nonce' ); ?>
        <?php submit_button( __( 'Import Expert Codes', 'apo-expert-codes' ) ); ?>
    </form>
    <?php endif; ?>

<!--    <div class="tablenav top">-->
<!--        <form method="get">-->
<!--            <input type="hidden" name="page" value="apo-expert-codes">-->
<!---->
<!--            <p class="search-box">-->
<!--                <input type="search" name="s" value="">-->
<!--                <input type="submit" class="button" value="--><?//= __( 'Search code', 'apo-expert-codes' ) ?><!--">-->
<!--            </p>-->
<!--        </form>-->

        <?php if ( $canManage ) :

        $Table = new Expert_Code_Table;
        echo '<form method="post">';
            $Table->prepare_items();
            $Table->search_box('Search ...','search_record');
            $Table->display();
            echo '</form>';

        ?>

<!--        <form -->
<!--            method="post"-->
<!--            action="--><?//= esc_html( admin_url( 'admin-post.php' ) ) ?><!--"-->
<!--        >-->
<!--        <input type="hidden" name="page" value="apo-expert-codes">-->
<!---->
<!--        <div class="alignleft actions bulkactions">-->
<!--            <label for="bulk-action-selector-top" class="screen-reader-text">--><?//= __( 'Bulk actions', 'apo-expert-codes' ) ?><!--</label>-->
<!--            <select name="action_type" id="bulk-action-selector-top">-->
<!--                <option value="-1">--><?//= __( 'Bulk actions', 'apo-expert-codes' ) ?><!--</option>-->
<!--                <option value="remove">--><?//= __( 'Remove', 'apo-expert-codes' ) ?><!--</option>-->
<!--            </select>-->
<!---->
<!--            <input type="hidden" name="action" value="apo_expert_codes_bulk_action_form">-->
<!---->
<!--            --><?php //wp_nonce_field( 'apo_expert_codes_bulk_action', 'apo_expert_codes_bulk_action_nonce' ); ?>
<!--            <input type="submit" class="button action" value="--><?//= __( 'Do action', 'apo-expert-codes' ) ?><!--">-->
<!--        </div>-->
<!--        --><?php //endif; ?>
<!--    </div>-->

<!--    <table class="wp-list-table widefat fixed striped">-->
<!--        <thead>-->
<!--            <tr>-->
<!--                --><?php //if ( $canManage ) : ?>
<!--                <td -->
<!--                    id="cb" -->
<!--                    class="manage-column column-cb check-column"-->
<!--                >-->
<!--                    <label class="screen-reader-text" for="cb-select-all-1">--><?//= __( 'Choose all', 'apo-expert-codes' ) ?><!--</label>-->
<!--                    <input id="cb-select-all-1" type="checkbox">-->
<!--                </td>-->
<!--                --><?php //endif; ?>
<!--                <th-->
<!--                    scope="col"-->
<!--                    id="expert-code"-->
<!--                    class="manage-column column-expert-code column-primary"-->
<!--                >-->
<!--                    --><?//= __( 'Expert Code', 'apovoice-expert-codes' ) ?>
<!--                </th>-->
<!--                <th-->
<!--                    scope="col"-->
<!--                    id="sales-rep-email"-->
<!--                    class="manage-column column-sales-rep-email"-->
<!--                >-->
<!--                    --><?//= __( 'Sales Rep Email', 'apovoice-expert-codes' ) ?>
<!--                </th>-->
<!--                <th-->
<!--                    scope="col"-->
<!--                    id="sales-rep-name"-->
<!--                    class="manage-column column-sales-rep-name"-->
<!--                >-->
<!--                    --><?//= __( 'Sales Rep Name', 'apovoice-expert-codes' ) ?>
<!--                </th>-->
<!--                <th-->
<!--                    scope="col"-->
<!--                    id="usages"-->
<!--                    class="manage-column column-usages"-->
<!--                >-->
<!--                    --><?//= __( 'Usages', 'apovoice-expert-codes' ) ?>
<!--                </th>-->
<!--                <th-->
<!--                    scope="col"-->
<!--                    id="used"-->
<!--                    class="manage-column column-used"-->
<!--                >-->
<!--                    --><?//= __( 'Used', 'apovoice-expert-codes' ) ?>
<!--                </th>-->
<!--                <th-->
<!--                    scope="col"-->
<!--                    id="created-at"-->
<!--                    class="manage-column column-created-at"-->
<!--                >-->
<!--                    --><?//= __( 'Created At', 'apovoice-expert-codes' ) ?>
<!--                </th>-->
<!--                <th-->
<!--                    scope="col"-->
<!--                    id="updated-at"-->
<!--                    class="manage-column column-updated-at"-->
<!--                >-->
<!--                    --><?//= __( 'Updated At', 'apovoice-expert-codes' ) ?>
<!--                </th>-->
<!--            </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--            --><?php //foreach ( $expertCodes as $expertCode ): ?>
<!--                <tr id="expert-code---><?//= $expertCode->expert_code ?><!--">-->
<!--                    --><?php //if ( $canManage ) : ?>
<!--                     <th scope="row" class="check-column">			-->
<!--                        --><?php //if ($expertCode->used == 0) : ?><!--   -->
<!--                            <input id="cb-select---><?//= $expertCode->expert_code ?><!--" type="checkbox" name="expertCodes[]" value="--><?//= $expertCode->expert_code ?><!--">-->
<!--                        --><?php //endif; ?>
<!--                    </th>-->
<!--                    --><?php //endif; ?>
<!--                    <td>--><?//= $expertCode->expert_code ?><!--</td>  -->
<!--                    <td>--><?//= $expertCode->sales_rep_email ?><!--</td>-->
<!--                    <td>-->
<!--                        <a href="/wp-admin/user-edit.php?user_id=--><?//= $expertCode->sales_rep_id ?><!--&wp_http_referer=%2Fwp-admin%2Fadmin.php?page=apo-expert-codes">-->
<!--                            --><?//= $expertCode->sales_rep_name ?>
<!--                        </a>-->
<!--                        --><?//= $expertCode->expert_code_name ?>
<!--                    </td>-->
<!--                    <td>--><?//= empty( $expertCode->usages ) ? '-' : $expertCode->usages ?><!--</td>-->
<!--                    <td>--><?//= $expertCode->used ?><!--</td>-->
<!--                    <td>-->
<!--                        --><?//= date_i18n( $dateFormat, strtotime( $expertCode->created_at ) ) ?>
<!--                        --><?//= date_i18n( $timeFormat, strtotime( $expertCode->created_at ) ) ?>
<!--                    </td>-->
<!--                    <td>-->
<!--                        --><?//= date_i18n( $dateFormat, strtotime( $expertCode->updated_at ) ) ?>
<!--                        --><?//= date_i18n( $timeFormat, strtotime( $expertCode->updated_at ) ) ?>
<!--                    </td>-->
<!--                </tr>-->
<!--            --><?php //endforeach; ?>
<!--        </tbody>-->
<!--    </table>-->
<?php //if ( $canManage ) : ?>
<!--</form>-->
<?php endif; ?>
</div>
