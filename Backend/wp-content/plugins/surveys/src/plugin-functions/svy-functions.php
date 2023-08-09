<?php

if(!function_exists('svy_filter_activatable_surveys_depending_on_training_completion')) {
	function svy_filter_activatable_surveys_depending_on_training_completion($response, $object, $request) {

		if(strpos($request->get_route(), '/wp/v2/surveys') !== false && $request->get_method() === 'GET') {

			if(is_array($response[0])) {

				$filterdSurveys = array_merge(
					array_filter( $response, 'svy_is_survey_activatable_and_depending_training_is_complete')
				);
				return $filterdSurveys;

			} else {

				if(!svy_is_survey_activatable_and_depending_training_is_complete($response)) {
					return new WP_Error('forbidden_survey', __('The survey must be first activated by a given training.', 'svy'), array('status' => 403));
				}
				return $response;

			}
			
		}
		return $response;

	}
}
add_action( 'rest_pre_echo_response', 'svy_filter_activatable_surveys_depending_on_training_completion', 10000, 3);

if(!function_exists('svy_is_survey_activatable_and_depending_training_is_complete')) {
	function svy_is_survey_activatable_and_depending_training_is_complete( $survey ) {
		global $wpdb;

		if( !key_exists('training_relation', $survey['acf']) || 
			(boolean) !$survey['acf']['training_relation']['activatable'] ) {
			return true;
		}

		$sql = $wpdb->prepare( "
			SELECT
				COUNT(`id`)
			FROM
				`{$wpdb->prefix}training_user_results`
			WHERE
				`user_id` = %d AND
				`training_id` = %d AND
				`is_complete` = 1
		", 
			get_current_user_id(), 
			$survey['acf']['training_relation']['training'] 
		);
		return (bool) (int) $wpdb->get_var( $sql );
	}
}

add_filter('manage_edit-surveys_columns', 'add_new_survey_columns');
function add_new_survey_columns($survey_columns) {
	$survey_columns['export'] = 'Export';
	$survey_columns['survey_link'] = 'Link';
	return $survey_columns;
}

add_action('manage_surveys_posts_custom_column', 'manage_survey_columns', 10, 2);
function manage_survey_columns($column_name, $id) {
	switch ($column_name) {
		case 'export':
			echo '<a target="blank" href="survey-export.php?id='.strval($id).'">Export Results</a>';
			break;
		case 'survey_link':
			$url = get_option( 'apo_frontend_url' )."/surveys/";
			echo '<a target="blank" href="'.$url.strval($id).'">'.$url.strval($id).'</a>';
			break;
		default:
			break;
	}
}

add_action('admin_head', 'my_export_column_style');
function my_export_column_style() {
    echo '<style type="text/css">';
    echo '.column-export, .column-survey_link { text-align: center !important; width: 20% !important; vertical-align: middle !important }';
    echo '</style>';
}

function wpse_76471_add_html() {
    global $post;

    if( $post->post_type == 'surveys') {

        $output = '<div style="margin-top: 32px;">';
            $output .= '<a target="blank" href="survey-export.php">'. __('Download Survey Bundle', 'awsm') .'</a>';
        $output .= '</div>';

        echo $output;
    }
}
add_action('admin_notices','wpse_76471_add_html', 100);
?>