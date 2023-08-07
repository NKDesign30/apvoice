<?php
/**
 * Create apo user levels menu/page
 * @return void
 */
function apo_user_levels_configuration_page()
{
    add_options_page( 'User levels configuration', 'User levels', 'manage_options', 'apo-user-levels', 'apo_user_levels_configuration_view' );
}

/**
 * @param $where
 * @return string|string[]
 */
function apo_user_levels_posts_where( $where )
{
    return str_replace("meta_key = 'trainings_$", "meta_key LIKE 'trainings_%", $where);
}

/**
 * Sync user level points by apo points table and user id
 * @return void
 */
function apo_user_levels_sync_user_data($userId)
{
    global $wpdb;

    $levels = get_option( 'apo_user_levels_options', [2 => 5]);
    $levelUpAfter = get_option( 'apo_user_levels_up_options', 5);

    $dbPrefix = $wpdb->get_blog_prefix(get_current_site_id());
    $pointsTable = $dbPrefix.'apo_points';

    $trainingSeriesQuery = "SELECT distinct related_id FROM `$pointsTable` WHERE user_id = " . $userId . " AND related_type = 'training-series'";
    $trainingSeriesResults = $wpdb->get_results($trainingSeriesQuery);

    $completedTrainings = [];
    foreach ($trainingSeriesResults as $trainingSeriesResult) {
        $trainingSerieId = $trainingSeriesResult->related_id;
        $taxonomies = get_taxonomies('','names');
        $terms = wp_get_post_terms($trainingSerieId, $taxonomies,  array("fields" => "slugs"));

        if (!in_array('scientific', $terms)) {
            $trainings = get_field('trainings', $trainingSerieId);
            foreach ($trainings as $training) {
                if (!in_array($training['training_id'], $completedTrainings)) {
                    $completedTrainings[] = $training['training_id'];
                }
            }
        }
    }

    if (count($completedTrainings)) {
        $completed = count($completedTrainings);
        //$addedPoints = (int) get_user_meta($userId, 'apo_user_level_added_points', true) ?: 0;
        $currentLevel = (int) get_user_meta($userId, 'apo_user_level', true) ?: 1;
        
        // Calc
        $userLevel = (($completed - ($completed % $levelUpAfter)) / $levelUpAfter) + 1;
        
        $addedPoints = 0;
        $pointsTable = $dbPrefix.'apo_points';

        $latestUserLevel = false;
        if ($userLevel > $currentLevel) {
            for ($i = $currentLevel; $i <= $userLevel; $i++) {
                if (isset($levels[$i])) {
                    $addPoints = $levels[$i];

                    $wpdb->insert($pointsTable, array(
                        'user_id' => $userId,
                        'points_earned' => $addPoints,
                        'related_type' => 'user-level-' . $i,
                        'related_id' => 0
                    ));
                    $latestUserLevel = $i;
                }
            }
        }


        /*
        $userLevelPoints = 0;
        foreach ($levels as $level => $points) {
            if ($level <= $userLevel) {
                $userLevelPoints += $points;
            }
        }

        // Add new points
        $addPoints = 0;
        if ($userLevelPoints !== $addedPoints && $userLevelPoints > $addedPoints) {
            $addPoints = $userLevelPoints - $addedPoints;
        }

        if ($addPoints > 0) {
            $pointsTable = $dbPrefix.'apo_points';
            $wpdb->insert($pointsTable, array(
                'user_id' => $userId,
                'points_earned' => $addPoints,
                'related_type' => 'user-level',
                'related_id' => 0
            ));
        }*/

        if ($latestUserLevel !== false) {
            update_user_meta( $userId, 'apo_user_level', $latestUserLevel);
        }
        //update_user_meta( $userId, 'apo_user_level_added_points', $userLevelPoints);
        update_user_meta( $userId, 'apo_user_level_completed_trainings', $completed);
    }
}

/**
 * Sync user level points by apo points table
 * @return void
 */
function apo_user_levels_sync_data_from_apo_points_table()
{
    global $wpdb;

    $levels = get_option( 'apo_user_levels_options', [2 => 5]);
    $levelUpAfter = get_option( 'apo_user_levels_up_options', 5);

    $dbPrefix = $wpdb->get_blog_prefix(get_current_site_id());
    $pointsTable = $dbPrefix.'apo_points';

    $pointsQuery = "SELECT distinct user_id FROM `$pointsTable`";
    $pointsResults = $wpdb->get_results($pointsQuery);

    foreach ($pointsResults as $pointsResult) {
        $userId = $pointsResult->user_id;
        apo_user_levels_sync_user_data($userId);
    }
}

/**
 * Sync user level points
 * @return void
 */
function apo_user_levels_sync_data()
{
    global $wpdb;

    $levels = get_option( 'apo_user_levels_options', [2 => 5]);
    $levelUpAfter = get_option( 'apo_user_levels_up_options', 5);

    $dbPrefix = $wpdb->get_blog_prefix(get_current_site_id());
    $trainingUserResultsTableName = $dbPrefix . 'training_user_results';

    $completedTrainingSeries = "SELECT distinct user_id FROM `$trainingUserResultsTableName` WHERE is_complete = 1";
    $completedTrainingSeriesResults = $wpdb->get_results($completedTrainingSeries);

    foreach ($completedTrainingSeriesResults as $completedTrainingSeriesResult) {
        $userId = $completedTrainingSeriesResult->user_id;

        $usersCompletedTrainingSeries = "SELECT distinct training_id FROM `$trainingUserResultsTableName` WHERE is_complete = 1 AND user_id = " . $userId;
        $usersCompletedTrainingSeriesResults = $wpdb->get_results($usersCompletedTrainingSeries);

        $completed = 0;
        foreach ($usersCompletedTrainingSeriesResults as $usersCompletedTrainingSeriesResult) {
            $posts = get_posts([
                'post_type' => 'training-series',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'training-category',
                        'field' => 'slug',
                        'terms' => 'scientific',
                    )
                ),
                'meta_query' => [
                    [
                        'meta_key' => 'trainings_$_training_id',
                        'meta_value' => $usersCompletedTrainingSeriesResult->training_id,
                        'meta_compare' => '='
                    ]
                ]
            ]);

            // No training series with scientific taxonomy founded
            if (empty($posts)) {
                $completed++;
            }
        }

        $addedPoints = (int) get_user_meta($userId, 'apo_user_level_added_points', true) ?: 0;

        // Calc
        $userLevel = (($completed - ($completed % $levelUpAfter)) / $levelUpAfter) + 1;
        $userLevelPoints = 0;
        foreach ($levels as $level => $points) {
            if ($level <= $userLevel) {
                $userLevelPoints += $points;
            }
        }

        // Add new points
        $addPoints = 0;
        if ($userLevelPoints !== $addedPoints) {
            $addPoints = $userLevelPoints - $addedPoints;
        }

        if ($addPoints > 0) {
            $pointsTable = $dbPrefix.'apo_points';
            $wpdb->insert($pointsTable, array(
                'user_id' => $userId,
                'points_earned' => $addPoints,
                'related_type' => 'user-level',
                'related_id' => 0
            ));
        }

        update_user_meta( $userId, 'apo_user_level', $userLevel);
        update_user_meta( $userId, 'apo_user_level_added_points', $userLevelPoints);
        update_user_meta( $userId, 'apo_user_level_completed_trainings', $completed);
    }
}

/**
 * @return WP_REST_Response
 */
function apo_user_levels_endpoint()
{
    $userId = get_current_user_id();
    
    $autoSync = (int) get_option( 'apo_user_levels_auto_sync', 0);

    if ($autoSync) {
        apo_user_levels_sync_user_data($userId);
    }

    $response = [];
    $response['level'] = (int) get_user_meta($userId, 'apo_user_level', true) ?: 1;
    //$response['earned_points'] = (int) get_user_meta($userId, 'apo_user_level_added_points', true) ?: 0;
    $response['completed_trainings'] = (int) get_user_meta($userId, 'apo_user_level_completed_trainings', true) ?: 0;

    $result = new WP_REST_Response($response, 200);
    $result->set_headers(array('Cache-Control' => 'no-cache'));

    return $result;
}

/**
 * Render apo user levels configuration view
 * @return void
 */
function apo_user_levels_configuration_view()
{
    // Save data
    if (isset($_POST['submit-apo-user-levels'])) {
        $postLevels = [];
        foreach ($_POST['levels']['level'] as $index => $val) {
            $postLevels[$val] = (int) $_POST['levels']['points'][$index] ?: 5;
        }
        //$postLevelUpAfter = (int) $_POST['level_up_after'] ?: 5;
        $postLevelUpAfter = 5; 
        $postAutoSync = $_POST['auto_sync_active'] == "1" ? 1 : 0;

        update_option('apo_user_levels_options', $postLevels);
        update_option('apo_user_levels_up_options', $postLevelUpAfter);
        update_option('apo_user_levels_auto_sync', $postAutoSync);
        

        // Sync user data
    } else if (isset($_POST['submit-apo-user-levels-sync'])) {
        apo_user_levels_sync_data_from_apo_points_table();
    }

    // Read data
    $levels = get_option( 'apo_user_levels_options', [2 => 5]);
    $levelUpAfter = get_option( 'apo_user_levels_up_options', 5);
    $autoSync = (int) get_option( 'apo_user_levels_auto_sync', 0);

    ?>
    <form method="post">
        <!-- levels configuration -->
        <table class="form-table apo-user-levels" role="presentation">
            <tbody>
            <tr>
                <th scope="row"><label for="level">Levels</label></th>
                <td class="level-list">
                    <?php
                    $i = 0;
                    foreach ($levels as $level => $points) { ?>
                        <p>
                            <input style="width:100px" name="levels[level][]" type="number" readonly value="<?= $level ?>" placeholder="Level" class="regular-text input-level">
                            <input style="width:100px" name="levels[points][]" type="number" value="<?= $points ?>" placeholder="Points" class="regular-text input-points">
                            <?php if ($i > 0) { ?>
                                <a href="#" style="margin-left:2px;">Remove level</a>
                            <?php } ?>
                        </p>
                        <?php $i++; } ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="form-table apo-user-levels" role="presentation">
            <tbody>
            <tr>
                <th></th>
                <td colspan="2">
                    <input type="button" id="add-apo-user-level" class="button button-primary" value="Add level">
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Level up after configuration -->
        <table class="form-table axpo-user-levels" role="presentation">
            <tbody>
            <tr style="display:none">
                <th scope="row"><label for="blogname">Level higher after how many training sessions?</label></th>
                <td><input name="level_up_after" type="number" value="<?= $levelUpAfter ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="auto_sync_active">Auto sync active</label></th>
                <td>
                    <select name="auto_sync_active" id="auto_sync_active">
                        <option <?php if (!$autoSync) { echo 'selected="selected"'; } ?> value="0">No</option>
                        <option <?php if ($autoSync) { echo 'selected="selected"'; } ?> value="1">Yes</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th></th>
                <td colspan="3">
                    <input type="submit" name="submit-apo-user-levels" id="submit" class="button button-primary" value="Save Changes">
                    <input type="submit" onclick="return confirm('Sure sync user data?')" name="submit-apo-user-levels-sync" id="submit" class="button button-primary" value="Sync user data">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
    <?php
}

/**
 * Add apo user levels script
 * @return void
 */
function apo_user_levels_configuration_view_enqueue()
{
    if (is_admin()) {
        wp_enqueue_script('apo_user_levels_script', APO_USER_LEVEL_PLUGIN_DIR . '/assets/js/apo_user_levels.js', ['jquery']);
    }
}