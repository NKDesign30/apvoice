<?php
use apo\trng\cpt\TrainingSeries;

if(!function_exists('trng_add_toplevel_admin_menu')) {
	 function trng_add_toplevel_admin_menu(){
	   add_menu_page( __('Trainings', 'trng'), __('Trainings', 'trng'), TrainingSeries::ACCESS_CAPABILITY,  'apo-trainings', 'trng_create_trainigs_frontpage', 'dashicons-welcome-learn-more', 5 );

	   add_submenu_page( 'apo-trainings', __('Add new Training Series', 'trng'), __('Add new Series', 'trng'), TrainingSeries::ACCESS_CAPABILITY, 'post-new.php?post_type=training-series' );
	   add_submenu_page( 'apo-trainings', __('Add new Training', 'trng'), __('Add new Training', 'trng'), TrainingSeries::ACCESS_CAPABILITY, 'post-new.php?post_type=trainings' );
	   add_submenu_page( 'apo-trainings', __('Categories', 'trng'), __('Categories', 'trng'), TrainingSeries::ACCESS_CAPABILITY, 'edit-tags.php?taxonomy=training-category&post_type=training-series' );
	 }
}
add_action( 'admin_menu', 'trng_add_toplevel_admin_menu' );

?>