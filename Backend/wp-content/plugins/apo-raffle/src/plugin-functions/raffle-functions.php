<?php

if(!function_exists('raffle_custom_plugin_functions')) {
	function raffle_custom_plugin_functions() {
		return 'Do your custom plugin functions here';
	}
}

add_action( 'admin_menu', 'register_newpage' );
function register_newpage() {
	add_submenu_page('edit.php?post_type=raffle', 'Raffle participants', '', 'administrator', 'apo-raffle-participants', 'raffleParticipants');
}

function raffleParticipants() {
	$raffleId = $_GET['id'];
	$raffleTitle = get_the_title($raffleId);

	global $wpdb;
	$participants = $wpdb->get_results("SELECT
																				contest,
																				firstName,
																				lastName,
																				pharmacyCity,
																				pharmacyName,
																				pharmacyStreet,
																				pharmacyCountry,
																				pharmacyZipCode,
																				pharmacyStreetNumber,
																				meta_value AS raffle_type
																			FROM
																				{$wpdb->prefix}apo_raffle wpar
																			JOIN
																				{$wpdb->prefix}postmeta wppm ON wpar.raffle_id = wppm.post_id AND wppm.meta_key = 'contest_type'
																			WHERE
																				raffle_id = $raffleId");
//print_r($participants);
	$tableHeadlines = [];

	if(count($participants) > 0)
		$tableHeadlines = array_keys(get_object_vars($participants[0]));

//	die();
	?>
	<div class="wrap">
		<h2>Participants of "<?php echo $raffleTitle ?>"</h2>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<?php
					foreach ($tableHeadlines as $headline) {
						echo '<th scope="col" class="manage-column column-pun-code column-primary">'.substr($headline, 0, 30).'</th>';
					}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
					$url = get_option( 'apo_frontend_url', null );
					foreach ($participants as $row) {
						echo '<tr>';
						foreach ($row as $key => $value) {
							if($key == "contest"){
								$path = $url.'/wp-json/apovoice/v1/media?p=/raffles/'.$value;
								if($row->raffle_type == 'Upload'){
									if(substr($path, -3) == "pdf")
										$value = '<a href="'.$path.'" target="_blank"><span class="dashicons dashicons-media-default"></span>'.strtoupper(substr($path, -3)).'</a>';
									else
										$value = '<a href="'.$path.'" target="_blank"><img class="raffle-thumbnail" src="'.$path.'"></a>';
								}

								echo '<td>'.$value.'</td>';
							} else {
								echo '<td>'.$value.'</td>';
							}
						}
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>

	<div class="wrap"><a href="raffle-export.php?id=<?php echo $raffleId ?>">Export as csv</a></div>

	<?php
};

add_filter('manage_edit-raffle_columns', 'add_new_raffle_columns');
function add_new_raffle_columns($raffle_columns) {
	$raffle_columns['participants'] = 'Participants';
	return $raffle_columns;
}

add_action('manage_raffle_posts_custom_column', 'manage_raffle_columns', 10, 2);
function manage_raffle_columns($column_name, $id) {
	switch ($column_name) {
		case 'participants':
			echo '<a href="admin.php?page=apo-raffle-participants&id='.strval($id).'">View participants</a>';
			break;
		default:
			break;
	}
}

add_action('admin_head', 'my_column_style');
function my_column_style() {
    echo '<style type="text/css">';
    echo '.column-participants { text-align: center !important; width: 20% !important; vertical-align: middle !important }';
    echo '</style>';
}

?>
