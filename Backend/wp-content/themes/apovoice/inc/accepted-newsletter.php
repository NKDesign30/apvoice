<?php

if (!class_exists('WP_List_Table')) {
    require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Accepted_Newsletter_Table extends WP_List_Table
{
    public function __construct() {
        parent::__construct(array(
            'singular' => 'Accepted Newsletter',
            'plural' => 'Accepted Newsletter',
            'ajax' => false
        ));
    }
    public static function get_records($per_page = 20, $page_number = 1) {
        global $wpdb;
        $current_blog_id = get_current_blog_id();

        $filters = "";

        if(strlen(trim($_POST['active']['training']) > 0))
            $filters .= " AND ".count(explode(',', $_POST['active']['training']))." = (SELECT COUNT(training_id) FROM {$wpdb->prefix}training_user_results wptur WHERE wptur.user_id = wpu.ID AND wptur.is_complete = '1' AND training_id IN ({$_POST['active']['training']}) ".(strlen(trim($_POST['date']) > 0) ? "AND created_at < '{$_POST['date']}'" : "")." )";
        if(strlen(trim($_POST['inactive']['training']) > 0))
            $filters .= " AND 0 = (SELECT COUNT(training_id) FROM {$wpdb->prefix}training_user_results wptur WHERE wptur.user_id = wpu.ID AND wptur.is_complete = '1' AND training_id IN ({$_POST['inactive']['training']}))";
        if(strlen(trim($_POST['active']['survey']) > 0))
            $filters .= " AND ".count(explode(',', $_POST['active']['survey']))." = (SELECT COUNT(survey_id) FROM {$wpdb->prefix}survey_user_results wpsur WHERE wpsur.user_id = wpu.ID AND wpsur.is_complete = '1' AND survey_id IN ({$_POST['active']['survey']}) ".(strlen(trim($_POST['date']) > 0) ? "AND created_at < '{$_POST['date']}'" : "")." )";
        if(strlen(trim($_POST['inactive']['survey']) > 0))
            $filters .= " AND 0 = (SELECT COUNT(survey_id) FROM {$wpdb->prefix}survey_user_results wpsur WHERE wpsur.user_id = wpu.ID AND wpsur.is_complete = '1' AND survey_id IN ({$_POST['inactive']['survey']}))";

        if( $_POST['s'] ){
            $filters .= " AND wpu.user_email LIKE '%{$_REQUEST['s']}%' OR wpu.user_nicename LIKE '%{$_REQUEST['s']}%'";
        }

        $sql = "SELECT
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
        wpu.user_registered DESC";

        $sql.= " LIMIT $per_page";
        $sql.= ' OFFSET ' . ($page_number - 1) * $per_page;
        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }
    function get_columns() {
        $columns = [
            'email' => __('Email', 'awesome') ,
            'nickname' => __('Nickname', 'awesome') ,
            'firstname' => __('Firstname', 'awesome') ,
            'lastname' => __('Lastname', 'awesome') ,
            'registered' => __('Registrierungsdatum', 'awesome') ,
        ];
        return $columns;
    }
    public function get_hidden_columns() {
        return array();
    }
    public function get_sortable_columns() {}
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'email':
                return $item['user_email'];
            case 'nickname':
                return $item['user_nicename'];
            case 'firstname':
                return $item['first_name'];
            case 'lastname':
                return $item['last_name'];
            case 'registered':
                return $item['user_registered'];
            default:
                return '';
        }
    }
    function column_cb($item) {}
    function column_your_name( $item ) {}
    public function get_bulk_actions() {}
    public static function delete_records($id) {}
    public static function record_count() {
        global $wpdb;
        $current_blog_id = get_current_blog_id();

        $filters = "";

        if(strlen(trim($_POST['active']['training']) > 0))
            $filters .= " AND ".count(explode(',', $_POST['active']['training']))." = (SELECT COUNT(training_id) FROM {$wpdb->prefix}training_user_results wptur WHERE wptur.user_id = wpu.ID AND wptur.is_complete = '1' AND training_id IN ({$_POST['active']['training']}) ".(strlen(trim($_POST['date']) > 0) ? "AND created_at < '{$_POST['date']}'" : "")." )";
        if(strlen(trim($_POST['inactive']['training']) > 0))
            $filters .= " AND 0 = (SELECT COUNT(training_id) FROM {$wpdb->prefix}training_user_results wptur WHERE wptur.user_id = wpu.ID AND wptur.is_complete = '1' AND training_id IN ({$_POST['inactive']['training']}))";
        if(strlen(trim($_POST['active']['survey']) > 0))
            $filters .= " AND ".count(explode(',', $_POST['active']['survey']))." = (SELECT COUNT(survey_id) FROM {$wpdb->prefix}survey_user_results wpsur WHERE wpsur.user_id = wpu.ID AND wpsur.is_complete = '1' AND survey_id IN ({$_POST['active']['survey']}) ".(strlen(trim($_POST['date']) > 0) ? "AND created_at < '{$_POST['date']}'" : "")." )";
        if(strlen(trim($_POST['inactive']['survey']) > 0))
            $filters .= " AND 0 = (SELECT COUNT(survey_id) FROM {$wpdb->prefix}survey_user_results wpsur WHERE wpsur.user_id = wpu.ID AND wpsur.is_complete = '1' AND survey_id IN ({$_POST['inactive']['survey']}))";

        if( isset($_REQUEST['s']) && empty( $_REQUEST['s'] ) === false ){
            $filters .= " AND wpu.user_email LIKE '%{$_REQUEST['s']}%' OR wpu.user_nicename LIKE '%{$_REQUEST['s']}%'";
        }

        $sql = "SELECT
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
        wpu.user_registered DESC";
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
        $data = self::get_records($per_page, $current_page);
        $this->set_pagination_args( [
            'total_items' => $total_items,
            'per_page' => $per_page,
        ]);
        $this->items = $data;
    }
}



// ------------ Frontend Settings Page ------------

function apo_accepted_newsletter_menu() {
    add_submenu_page(
        'users.php',
        'User Export (Accepted Newsletter)',
        'User Export (Accepted Newsletter)',
        'manage_options',
        'apo-accepted-newsletter',
        'apo_accepted_newsletter_menu_options'
    );
}

function apo_accepted_newsletter_menu_options() {
	if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

//    $users = apo_get_accepted_newsletter();
    $trainings = new WP_Query(
        array(
            'post_type' => 'trainings',
            'posts_per_page' => 0,
            'orderby' => 'DESC',
            'posts_per_page' => -1
        )
    );
    $surveys = new WP_Query(
        array(
            'post_type' => 'surveys',
            'posts_per_page' => 0,
            'orderby' => 'DESC',
            'posts_per_page' => -1
        )
    );

    ?>

	<div class="wrap">
        <h1>User Export (Accepted Newsletter)</h1>
        <form method="post" class="filterForm">
            <div class="filters">
                <?php if(count($trainings->posts) > 0){?>
                    <div class="multiselect" tabindex="0">
                        <input type="hidden" class="active" name="active[training]" value="<?php echo (isset($_POST['active']) && isset($_POST['active']['training'])) ? $_POST['active']['training'] : "" ?>">
                        <input type="hidden" class="inactive" name="inactive[training]" value="<?php echo (isset($_POST['inactive']) && isset($_POST['inactive']['training'])) ? $_POST['inactive']['training'] : "" ?>">
                        <div class="selected">Trainings</div>
                        <div class="options">
                            <?php foreach($trainings->posts as $post){
                                echo "<div class='option' data-id='$post->ID'>$post->post_title</div>";
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if(count($surveys->posts) > 0){?>
                    <div class="multiselect" tabindex="0">
                        <input type="hidden" class="active" name="active[survey]" value="<?php echo (isset($_POST['active']) && isset($_POST['active']['survey'])) ? $_POST['active']['survey'] : "" ?>">
                        <input type="hidden" class="inactive" name="inactive[survey]" value="<?php echo (isset($_POST['inactive']) && isset($_POST['inactive']['survey'])) ? $_POST['inactive']['survey'] : "" ?>">
                        <div class="selected">Surveys</div>
                        <div class="options">
                            <?php foreach($surveys->posts as $post){
                                echo "<div class='option' data-id='$post->ID'>$post->post_title</div>";
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <input type="date" name="date" />
                <button class="button" type="submit">Filter</button>
            </div>
                <div class="">
                    <input type="hidden" value="0" name="accepted_newsletter" />
                    <input type="checkbox" <?php echo ( !isset($_POST['accepted_newsletter']) || $_POST['accepted_newsletter'] > 0 ) ? "checked" : "" ?> value="1" id="accepted_newsletter" name="accepted_newsletter" />
                    <label for="accepted_newsletter">Accepted Newsletter</label>
                </div>
<!--            <span>--><?php //echo count($users) ?><!-- selected</span>-->
        </form>
        <p><a class="exportFilteredUsers" href="users-export.php?newsletter=true">Export Users as CSV</a></p>

        <?php
//        require_once(get_template_directory().'/inc/admin/event_registrations.php');
        $acceptedNewsletter = new Accepted_Newsletter_Table;
        echo '<form method="post">';
        $acceptedNewsletter->prepare_items();
        $acceptedNewsletter->search_box('Search ...','search_record');
        $acceptedNewsletter->display();
        echo '</form>';

        ?>


<!--        <table class="wp-list-table widefat fixed striped">-->
<!--            <thead>-->
<!--                <tr>-->
<!--                    <th>Email</th>-->
<!--                    <th>Nickname</th>-->
<!--                    <th>Firstname</th>-->
<!--                    <th>Lastname</th>-->
<!--                    <th>Registrierungsdatum</th>-->
<!--                </tr>-->
<!--            </thead>-->
            <?php

            //$post_per_page = 10;
            //$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
            //$offset = ( $page * $post_per_page ) - $post_per_page;
            //$latestposts = $wpdb->get_results( $query . " ORDER BY post_date LIMIT ${offset}, ${items_per_page}" );



//                foreach($users AS $user){
//                    echo "<tr>";
//                        echo "<td>".$user->user_email."</td>";
//                        echo "<td>".$user->user_nicename."</td>";
//                        echo "<td>".$user->first_name."</td>";
//                        echo "<td>".$user->last_name."</td>";
//                        echo "<td>".$user->user_registered."</td>";
//                    echo "</tr>";
//                }
            ?>
<!--        </table>-->

        <?php
//        echo '<div class="pagination">';
//            echo paginate_links( array(
//                'base' => add_query_arg( 'cpage', '%#%' ),
//                'format' => '',
//                'prev_text' => __('&laquo;'),
//                'next_text' => __('&raquo;'),
//                'total' => ceil($total / $post_per_page),
//                'current' => $page,
//                'type' => 'list'
//            ));
//        echo '</div>';
        ?>

    </div>

    <?php
}
//
//function apo_get_accepted_newsletter($offset = 0, $items_per_page = 10, $get_all = false){
//    global $wpdb;
//    $current_blog_id = get_current_blog_id();
//
//    $filters = "";
//
//    if(strlen(trim($_POST['active']['training']) > 0))
//    $filters .= " AND ".count(explode(',', $_POST['active']['training']))." = (SELECT COUNT(training_id) FROM {$wpdb->prefix}training_user_results wptur WHERE wptur.user_id = wpu.ID AND wptur.is_complete = '1' AND training_id IN ({$_POST['active']['training']}) ".(strlen(trim($_POST['date']) > 0) ? "AND created_at < '{$_POST['date']}'" : "")." )";
//    if(strlen(trim($_POST['inactive']['training']) > 0))
//    $filters .= " AND 0 = (SELECT COUNT(training_id) FROM {$wpdb->prefix}training_user_results wptur WHERE wptur.user_id = wpu.ID AND wptur.is_complete = '1' AND training_id IN ({$_POST['inactive']['training']}))";
//    if(strlen(trim($_POST['active']['survey']) > 0))
//    $filters .= " AND ".count(explode(',', $_POST['active']['survey']))." = (SELECT COUNT(survey_id) FROM {$wpdb->prefix}survey_user_results wpsur WHERE wpsur.user_id = wpu.ID AND wpsur.is_complete = '1' AND survey_id IN ({$_POST['active']['survey']}) ".(strlen(trim($_POST['date']) > 0) ? "AND created_at < '{$_POST['date']}'" : "")." )";
//    if(strlen(trim($_POST['inactive']['survey']) > 0))
//    $filters .= " AND 0 = (SELECT COUNT(survey_id) FROM {$wpdb->prefix}survey_user_results wpsur WHERE wpsur.user_id = wpu.ID AND wpsur.is_complete = '1' AND survey_id IN ({$_POST['inactive']['survey']}))";
//   // print_r($filters);
//    $query = "SELECT
//                wpu.*,
//                (SELECT meta_value FROM {$wpdb->base_prefix}usermeta WHERE {$wpdb->base_prefix}usermeta.user_id = wpu.ID AND meta_key = 'first_name') AS first_name,
//                (SELECT meta_value FROM {$wpdb->base_prefix}usermeta WHERE {$wpdb->base_prefix}usermeta.user_id = wpu.ID AND meta_key = 'last_name') AS last_name
//            FROM
//                {$wpdb->base_prefix}users AS wpu
//            LEFT JOIN
//                {$wpdb->base_prefix}usermeta AS wpum ON wpum.user_id = wpu.ID
//            WHERE
//                ((wpum.meta_key = 'accepted_newsletter' AND wpum.meta_value = 'data_protection_regulations') OR wpu.user_registered < '2020-10-09 00:00:00') AND
//                (SELECT wpum2.meta_value FROM {$wpdb->base_prefix}usermeta AS wpum2 WHERE wpum2.user_id = wpu.ID AND wpum2.meta_key = 'primary_blog') = '{$current_blog_id}'
//                {$filters} GROUP BY wpu.ID ORDER BY wpu.user_registered DESC";
//
//    if($get_all === false){
////        echo '<pre>';
////        print_r($query. " LIMIT ". $offset .", ". $items_per_page);
////        echo '<pre>';
//
//        $pending = $wpdb->get_results($query. " LIMIT ". $offset .", ". $items_per_page);
//    } else {
//        $pending = $wpdb->get_results($query);
//    }
//
//
//    return $pending;
//}


add_action( 'admin_menu', 'apo_accepted_newsletter_menu' );
