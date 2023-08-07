<?php 

// ------------ Frontend Settings Page ------------

function apo_pending_redemers_menu() {
    add_submenu_page(
        'users.php',
        'Pending Redeemers',
        'Pending Redeemers',
        'manage_options',
        'apo-prending-redemers',
        'apo_pending_redemers_menu_options'
    );
}

function apo_pending_redemers_menu_options() {
	if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    if(isset($_POST['user_ids'])){
        apo_process_pending_redemers($_POST['user_ids']);
    }

    $users = apo_get_pending_redemers();
    ?>

	<div class="wrap">
		<?php $status = isset( $_GET['status'] ) ? $_GET['status'] : 'pending'; ?>
        <h1>Pending Redeemers <?php echo $status == 'suspicious' ? __( '- Suspicious', 'apovoice' ) : ''; ?></h1>
		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<form class="apo-users-bulk" method="POST" action="?page=apo-prending-redemers<?php echo $status == 'suspicious' ? '&status=suspicious' : ''; ?>">
					<label for="bulk-action-selector-top" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'apovoice' ); ?></label>
					<select name="action" id="bulk-action-selector-top">
						<option value="-1"><?php esc_html_e( 'Bulk Action', 'apovoice' ); ?></option>
						<option value="activate" class="hide-if-no-js"><?php esc_html_e( 'Activate', 'apovoice' ); ?></option>
						<option value="<?php echo $status == 'suspicious' ? 'unsuspicious' : 'suspicious'; ?>"><?php $status == 'suspicious' ? esc_html_e( 'Mark as non-suspicious', 'apovoice' ) : esc_html_e( 'Mark as suspicious', 'apovoice' ); ?></option>
					</select>
					<input type="submit" id="apo_doaction" class="button action" value="<?php esc_attr_e( 'Apply', 'apovoice' ); ?>">
				</form>
			</div>
			<div class="alignleft actions">
				<form action="" method="GET">
					<?php $status = isset( $_GET['status'] ) ? $_GET['status'] : ''; ?>
					<input type="hidden" name="page" value="apo-prending-redemers">
					<select name="status" class="apo-filter-status">
						<option value=""><?php esc_html_e( 'Filter', 'apovoice' ); ?></option>
						<option value="pending" class="hide-if-no-js" <?php echo $status == 'pending' ? 'selected' : ''; ?>><?php esc_html_e( 'Pending activation', 'apovoice' ); ?></option>
						<option value="suspicious" <?php echo $status == 'suspicious' ? 'selected' : ''; ?>><?php esc_html_e( 'Suspicious', 'apovoice' ); ?></option>
					</select>
				</form>
			</div>
		</div>
        <table class="wp-list-table widefat fixed striped apo-users">
            <thead>
                <tr>
					<th><input type="checkbox" class="apo-user-cb-bulk"></th>
                    <th>Email</th>
                    <th>Nickname</th>
                    <th>Anzeigename</th>
                    <th>Registrierungsdatum</th>
                    <th></th>
                </tr>
            </thead>
            <?php
                foreach($users AS $user){
                    echo "<tr>";
						echo "<td><input type='checkbox' class='apo-user-cb' value='$user->ID'></td>";
                        echo "<td>".$user->user_email."</td>";
                        echo "<td>".$user->user_nicename."</td>";
                        echo "<td>".$user->display_name."</td>";
                        echo "<td>".$user->user_registered."</td>";
                        echo "<td>
                                <form style='display:inline' method='post' action='?page=apo-prending-redemers" . ( $status == 'suspicious' ? '&status=suspicious' : '' ) . "'>
									<input type='hidden' name='action' value='activate'>
                                    <input type='hidden' name='user_ids[]' value='".$user->ID."'>
                                    <button type='submit'>" . __( 'Activate', 'apovoice' ) . "</button>
                                </form>
								<form style='display:inline' method='post' action='?page=apo-prending-redemers" . ( $status == 'suspicious' ? '&status=suspicious' : '' ) . "'>
									<input type='hidden' name='action' value='" . ( $status == 'suspicious' ? 'unsuspicious' : 'suspicious' ) . "'>
                                    <input type='hidden' name='user_ids[]' value='".$user->ID."'>
                                    <button type='submit'>" . ( $status == 'suspicious' ? __( 'Non-Suspicious', 'apovoice' ) : __( 'Suspicious', 'apovoice' ) ) . "</button>
                                </form>
                             </td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>

    <?php
}

function apo_get_pending_redemers(){
    global $wpdb;
    $current_blog_id = get_current_blog_id();
	$status = isset( $_GET['status'] ) ? $_GET['status'] : 'pending';
	$status_no = $status == 'suspicious' ? 2 : 1;

    $pending = $wpdb->get_results("SELECT
                                        wpu.*
                                    FROM
                                        {$wpdb->base_prefix}users AS wpu
                                    LEFT JOIN
                                        {$wpdb->base_prefix}usermeta AS wpum ON wpum.user_id = wpu.ID
                                    WHERE
                                        wpum.meta_key = 'is_pending' AND wpum.meta_value = $status_no AND 
                                        (SELECT wpum2.meta_value FROM {$wpdb->base_prefix}usermeta AS wpum2 WHERE wpum2.user_id = wpu.ID AND wpum2.meta_key = 'primary_blog') = '{$current_blog_id}'");

    return $pending;
}

function apo_process_pending_redemers($ids){
    global $wpdb;

	$ids = ( array ) $ids;
	$ids = array_map( 'intval', $ids );
	$ids = array_filter( $ids );
	$ids = array_unique( $ids );

	$action = $_POST['action'];

	if ( ! in_array( $action, array( 'activate', 'suspicious', 'unsuspicious' ) ) ) return;

	if ( $action == 'activate' ) {
		$pending = $wpdb->get_results("UPDATE
											{$wpdb->base_prefix}usermeta AS wpum
										SET
											meta_value = 0
										WHERE
											wpum.meta_key = 'is_pending' AND wpum.user_id IN (". implode( ', ', $ids ) .")");

		return $pending;
	} elseif( $action == 'suspicious' ) {
		$suspicious = $wpdb->get_results("UPDATE
											{$wpdb->base_prefix}usermeta AS wpum
										SET
											meta_value = 2
										WHERE
											wpum.meta_key = 'is_pending' AND wpum.user_id IN (". implode( ', ', $ids ) .")");

		return $suspicious;
	} elseif( $action == 'unsuspicious' ) {
		$unsuspicious = $wpdb->get_results("UPDATE
											{$wpdb->base_prefix}usermeta AS wpum
										SET
											meta_value = 1
										WHERE
											wpum.meta_key = 'is_pending' AND wpum.user_id IN (". implode( ', ', $ids ) .")");

		return $unsuspicious;
	}
}

add_action( 'admin_menu', 'apo_pending_redemers_menu' );

function apo_enqueue_admin_scripts( $hn ) {
	if ( $hn != 'users_page_apo-prending-redemers' ) return;
	wp_enqueue_script( 'apo-admin-2', get_stylesheet_directory_uri() . '/js/admin.js', array( 'jquery' ), null, true );
}

add_action( 'admin_enqueue_scripts', 'apo_enqueue_admin_scripts' );
