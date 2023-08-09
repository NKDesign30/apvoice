<?php
class Survey_Log_Table
{
    public function __construct()
    {

    }

    public static function get_records($user_id)
    {
        global $wpdb;

        $sql = "SELECT sur.survey_id, sur.created_at, sur.is_complete,";
        $sql .= " (SELECT post_title FROM {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.ID = sur.survey_id) AS title";
		$sql .= " FROM {$wpdb->prefix}survey_user_results AS sur";
		$sql .= " WHERE `user_id` = {$user_id} AND `is_complete` = 1";
        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }


    public static function record_count($user_id)
    {
        global $wpdb;

        $sql = "SELECT sur.survey_id, sur.created_at, sur.is_complete,";
        $sql .= " (SELECT post_title FROM {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.ID = sur.survey_id) AS title";
        $sql .= " FROM {$wpdb->prefix}survey_user_results AS sur";
        $sql .= " WHERE `user_id` = {$user_id} AND `is_complete` = 1";

        return count($wpdb->get_results($sql));
    }



    public function display()
    {

        $user_id = $_GET['user_id'];

        echo '<pre>';
        print_r($_POST['reset_survey_id']);

        echo '</pre>';

        if(isset($_POST['reset_survey_id'])){
            echo 'test';
            self::reset_survey($user_id, $_POST['reset_survey_id']);
        }

        $total_items = self::record_count($user_id);
        $data = self::get_records($user_id);

        $dateFormat = get_option( 'date_format' );
        $timeFormat = get_option( 'time_format' );

        $textdomain = 'apovoice';

        $columns = array(
            __('Title', $textdomain),
            __('Date', $textdomain),
            __('Action', $textdomain),
        );

        $out = '<table id="survey_table" class="wp-list-table widefat fixed striped">';
            $out .= '<thead>';
                $out .= '<tr>';
                    foreach( $columns as $v ){
                        $slug = sanitize_title($v);

                        $out .= '<th class="manage-column column-'. $slug .' column-primary">';
                        $out .= $v;
                        $out .= '</th>';
                    }
                $out .= '</tr>';
            $out .= '</thead>';

            $out .= '<tbody>';

            foreach( $data as $v ){
                $out .= '<tr class="survey_row_'. $v['survey_id'] .'">';
                    $out .= '<td>'. $v['title'] .'</td>';
                    $out .= '<td>'. date_i18n( $dateFormat, strtotime($v['created_at'])) .'</td>';
                    $out .= '<td>';
                    if(current_user_can('administrator')){
                        $out .= '<button
                        type="button" class="reset_survey_btn" 
                        data-id="'. $v['survey_id'] .'">'. __('Remove Survey', 'apovoice') .'</button>';
                    }
                    $out .= '</td>';
                $out .= '</tr>';
            }

            $out .= '</tbody>';
        $out .= '</table>';

        echo $out;

        ?>
        <script type="text/javascript" >
            jQuery(document).ready(function($) {

                jQuery('#survey_table').on('click', '.reset_survey_btn', function(){
                    let survey_id = jQuery(this).data('id');
                    // let row = jQuery(this).parent().parent();
                    let data = {
                        'action': 'apo_reset_survey',
                        'user_id': <?php echo $user_id; ?>,
                        'survey_id': survey_id
                    };

                    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                    jQuery.post(ajaxurl, data, function(response) {
                        console.log(response);

                        if(response > 0 && response !== false){
                            jQuery('.survey_row_' + survey_id).remove()
                        } else {
                            console.log('Fehler beim Löschen aufgetreten.');
                        }
                    });
                });
            });
        </script> <?php

    }
}


//if (!class_exists('WP_List_Table')) {
//    require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
//}
//
//class Survey_Log_Table extends WP_List_Table
//{
//    public function __construct() {
//        parent::__construct(array(
//            'singular' => 'Survey Log Table',
//            'plural' => 'Survey Log Table',
//            'ajax' => false
//        ));
//    }
//    public static function get_records($per_page = 10, $page_number = 1, $user_id) {
//        global $wpdb;
//
//        $filters = "";
//        if( isset($_REQUEST['s']) && empty( $_REQUEST['s'] ) === false ){
//            $filters .= " AND title LIKE '%{$_REQUEST['s']}%'";
//        }
//
//        $sql = "
//			SELECT sur.survey_id,
//			       sur.created_at,
//			       (SELECT post_title FROM {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.ID = sur.survey_id) AS title
//			FROM
//				{$wpdb->prefix}survey_user_results AS sur
//			WHERE
//				`user_id` = {$user_id} AND
//				`is_complete` = 1
//                {$filters}
//		";
//
//        $sql.= " LIMIT $per_page";
//        $sql.= ' OFFSET ' . ($page_number - 1) * $per_page;
//        $result = $wpdb->get_results($sql, 'ARRAY_A');
//
//        return $result;
//    }
//    function get_columns() {
//        $columns = [
//            'title' => __('Title', 'awesome') ,
//            'created_at' => __('Datum', 'awesome') ,
//        ];
//        return $columns;
//    }
//    public function get_hidden_columns() {
//        return array();
//    }
//    public function get_sortable_columns() {}
//    public function column_default( $item, $column_name ) {
//        switch ( $column_name ) {
//            default:
//                return $item[$column_name];
//        }
//    }
//    function column_cb($item) {}
//    function column_your_name( $item ) {}
//    public function get_bulk_actions() {}
//    public static function delete_records($id) {}
//    public static function record_count($user_id) {
//        global $wpdb;
//
//        $filters = "";
//        if( isset($_REQUEST['s']) && empty( $_REQUEST['s'] ) === false ){
//            $filters .= " AND title LIKE '%{$_REQUEST['s']}%'";
//        }
//
//        $sql = "SELECT sur.survey_id, sur.created_at,
//	        (SELECT post_title FROM {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.ID = sur.survey_id) AS title
//			FROM
//                    {$wpdb->prefix}survey_user_results AS sur
//			WHERE
//				`user_id` = {$user_id} AND
//				`is_complete` = 1
//                {$filters}";
//
//        return count($wpdb->get_results($sql));
//    }
//    public function no_items() {}
//    public function process_bulk_action() {}
//    public function prepare_items(){
//        $columns = $this->get_columns();
//        $hidden = $this->get_hidden_columns();
//        $sortable = $this->get_sortable_columns();
//        $this->_column_headers = array( $columns, $hidden, $sortable );
//        $this->process_bulk_action();
//        $per_page = 50;
//        $current_page = $this->get_pagenum();
//        $user_id = $_GET['user_id'];
//        $total_items = self::record_count($user_id);
//        $data = self::get_records($per_page, $current_page, $user_id);
//        $this->set_pagination_args( [
//            'total_items' => $total_items,
//            'per_page' => $per_page,
//        ]);
//        $this->items = $data;
//    }
//}