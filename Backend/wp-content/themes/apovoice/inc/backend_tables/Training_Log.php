<?php
class Training_Log_Table
{
    public function __construct()
    {

    }

    public static function get_records($user_id)
    {
        global $wpdb;

        $sql = "SELECT training_id, created_at, is_complete,";
        $sql .= " (SELECT post_title FROM {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.ID = training_id) AS title";
		$sql .= " FROM {$wpdb->prefix}training_user_results";
		$sql .= " WHERE `user_id` = {$user_id} AND `is_complete` = 1";
        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }


    public static function record_count($user_id)
    {
        global $wpdb;

        $sql = "SELECT training_id, created_at, is_complete,";
        $sql .= " (SELECT post_title FROM {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.ID = training_id) AS title";
        $sql .= " FROM {$wpdb->prefix}training_user_results";
        $sql .= " WHERE `user_id` = {$user_id} AND `is_complete` = 1";

        return count($wpdb->get_results($sql));
    }

    public function display()
    {
        $user_id = $_GET['user_id'];
        $total_items = self::record_count($user_id);
        $data = self::get_records($user_id);

        $textdomain = 'apovoice';

        $columns = array(
            __('Title', $textdomain),
            __('Date', $textdomain),
        );

        $out = '<table class="wp-list-table widefat fixed striped">';
            $out .= '<thead>';
                $out .= '<tr>';
                    foreach( $columns as $v ){
                        $slug = sanitize_title($v);

                        $out .= '<th scope="col" id="'. $slug .'" class="manage-column column-'. $slug .' column-primary">';
                        $out .= $v;
                        $out .= '</th>';
                    }
                $out .= '</tr>';
            $out .= '</thead>';

            $out .= '<tbody>';

            foreach( $data as $v ){
                $out .= '<tr>';
                    $out .= '<td>'. $v['title'] .'</td>';
                    $out .= '<td>'. $v['created_at'] .'</td>';
                $out .= '</tr>';
            }

            $out .= '</tbody>';
        $out .= '</table>';

        echo $out;
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