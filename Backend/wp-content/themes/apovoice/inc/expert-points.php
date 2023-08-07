<?php 

// ------------ Frontend Settings Page ------------

function apo_expert_points_menu() {
    add_submenu_page(
        '',
        '',
        '',
        'manage_options',
        'apo-expert-points',
        'apo_expert_points_menu_options'
    );
}

function apo_expert_points_menu_options() {
	if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    if(!isset($_GET['user_id'])){
        wp_die( __( 'No User selected.' ) );
    }

    if(isset($_POST['user_id'])){
        apo_add_expert_points();
    }

    $points = apo_get_expert_points();
    print_r($_POST);
    ?>

	<div class="wrap">
        <h1>Experten Punkte</h1>
        <form method="POST" action="?page=apo-expert-points&user_id=<?php echo $_GET['user_id']?>" >
            <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']?>">
            <div style="display:inline-flex;align-items:center;margin-bottom:20px;">
                <div>
                    <input type="text" name="points" placeholder="Points">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="type" placeholder="Type">
                </div>
                <div class="col-sm-3">
                    <input type="number" name="related" placeholder="Related">
                </div>
                <div class="col-sm-3">
                    <button type="submit">Add</button>
                </div>
            </div>
        </form>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Points</th>
                    <th>Type</th>
                    <th>Related ID</th>
                    <th>Date</th>
                </tr>
            </thead>
            <?php
                foreach($points AS $entry){
                    echo "<tr>";
                        echo "<td>".$entry->points_earned."</td>";
                        echo "<td>".$entry->related_type."</td>";
                        echo "<td>".$entry->related_id."</td>";
                        echo "<td>".$entry->created_at."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>

    <?php
}

function apo_get_expert_points(){
    global $wpdb;
    $current_blog_id = get_current_blog_id();

    $pending = $wpdb->get_results("SELECT
                                        wpep.*
                                    FROM
                                        {$wpdb->prefix}expert_points AS wpep
                                    WHERE
                                        wpep.user_id = '".$_GET['user_id']."' ");

    return $pending;
}

function apo_add_expert_points(){
    global $wpdb;
    try{
        $pending = $wpdb->query("INSERT INTO
                                            {$wpdb->prefix}expert_points
                                            (
                                                `user_id`,
                                                `points_earned`,
                                                `related_type`,
                                                `related_id`
                                            )
                                        VALUES
                                            (
                                                '".$_POST["user_id"]."',
                                                '".$_POST["points"]."',
                                                '".$_POST["type"]."',
                                                '".$_POST["related"]."'
                                            )
                                            ");
    }catch(Exception $e){
        wp_die( __( 'Error while adding the expert points.' ) );
    }
}

add_action( 'admin_menu', 'apo_expert_points_menu' );
