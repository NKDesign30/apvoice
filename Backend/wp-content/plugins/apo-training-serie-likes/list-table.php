<?php

class ApoTrainingSeriesTable
{
    /**
     * Constructor will create the menu item
     */
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'addSubMenu' ));
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function addSubMenu()
    {
        add_submenu_page("apo-trainings", "Reporting", "Reporting", 0, "apo-trainings-reporting", array($this, 'listTablePage'));
    }

    /**
     * Display the list table page
     */
    public function listTablePage()
    {
        $table = new ApoTrainingSeriesWpTable();
        $table->prepare_items();
        ?>
        <div class="wrap">
            <h2>Reporting</h2>
            <a href="<?= APO_TRAINING_SERIES_PLUGIN_DIR_URL ?>export.php">Export as CSV</a>
            <?php $table->display(); ?>
        </div>
        <?php
    }
}

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class ApoTrainingSeriesWpTable extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();

        $perPage = 20;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     */
    public function get_columns()
    {
        $columns = array(
            'training_series_id' => 'Training Series ID',
            'training_name' => 'Training Name',
            'training_total' => 'Completed',
            'likes' => 'Likes'
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     */
    public function get_sortable_columns()
    {
        return array();
    }

    /**
     * Get the table data
     */
    public function table_data()
    {
        global $wpdb;

        $data = array();
        $sql = "SELECT `{$wpdb->prefix}training_series_reporting`.*,
                (SELECT count(*) FROM {$wpdb->prefix}apo_points WHERE related_id=`{$wpdb->prefix}training_series_reporting`.training_series_id AND 
                    related_type = 'training-series') as total
                FROM `{$wpdb->prefix}training_series_reporting`";
        $result = $wpdb->get_results($sql, 'ARRAY_A');

        foreach ($result as $item) {
            $trainingSeries = get_post($item['training_series_id']);
            $data[] = [
                'training_series_id' => $item['training_series_id'],
                'training_name' => $trainingSeries->post_title,
                'training_total' => $item['total'],
                'likes' => $item['likes'],
            ];
        }

        return $data;
    }

    /**
     * Define what data to show on each column of the table
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'training_series_id':
            case 'training_name':
            case 'training_total':
            case 'likes':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
    }
}
?>