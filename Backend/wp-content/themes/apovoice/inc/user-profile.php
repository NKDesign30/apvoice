<?php

use apo\pun\models\PUN;

if (!class_exists('Survey_Log_Table')) {
    require_once(get_template_directory() . '/inc/backend_tables/Survey_Log.php');
}

if (!class_exists('Training_Log_Table')) {
    require_once(get_template_directory() . '/inc/backend_tables/Training_Log.php');
}


// ------------ User Profile ------------
function apo_show_extra_profile_fields($user)
{
    global $wpdb;
    $form_of_address = get_user_meta($user->ID, 'form_of_address', true);
    $is_pending = get_user_meta($user->ID, 'is_pending', true);
    $upun = get_user_meta($user->ID, 'registered_pharmacy_unique_number', true);
    $expertOnlyPharmacies = json_decode(get_user_meta($user->ID, 'expert_only_pharmacies', true));
    $title = get_user_meta($user->ID, 'title', true);
    $job = get_user_meta($user->ID, 'job', true);
    $working_since = get_user_meta($user->ID, 'working_since', true);
    $age = get_user_meta($user->ID, 'age', true);
    $priorities = maybe_unserialize(get_user_meta($user->ID, 'priorities', true));
    $tasks = maybe_unserialize(get_user_meta($user->ID, 'tasks', true));
    $other_priority = array_values(array_filter($priorities, function ($priority) {
        return !in_array($priority, array(
            'consulting',
            'purchasing',
            'productmanagement',
            'others',
        ));
    }));

    $puns = new PUN();
    $pun_arr = array();
    foreach ($puns->queryResult() as $pun) {
        $pun_arr[$pun->id] = $pun;
    }
    unset($puns);

    $expertOnlyPharmacies_sorted = array();
    foreach ($expertOnlyPharmacies[0] as $field) {
        $expertOnlyPharmacies_sorted[$field->title] = $field->value;
    }
    $other_priority = empty($other_priority) ? '' : $other_priority[0];

    $requestForm = get_option("apo_request_form", null);
    $gfentry = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gf_entry gfe JOIN {$wpdb->prefix}gf_entry_meta gfem ON gfe.id = gfem.entry_id WHERE gfe.created_by = {$user->ID} AND gfe.form_id = {$requestForm}");
    $entry = GFAPI::get_entry($gfentry[0]->entry_id);

if (isset($_POST['confirmationMail'])) {
    // Überprüfen, ob die E-Mail-Adresse des Benutzers vorhanden ist und eine gültige E-Mail-Adresse ist
    $user_email = $user->user_email;
    if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $email_to = $user_email;

            // E-Mail-Betreff und -Inhalt
            $subject = "Los geht's!";
            $message = "Dein apovoice Account ist startklar. Du kannst Dich jetzt einloggen und loslegen. Wir wünschen Dir viel Spaß auf unserer Online-Plattform.";

            // E-Mail senden
            if (wp_mail($email_to, $subject, $message)) {
                // E-Mail erfolgreich gesendet
                echo "E-Mail erfolgreich gesendet.";
            } else {
                // Fehler beim Senden der E-Mail
                echo "Fehler beim Senden der E-Mail. Bitte überprüfe deine Servereinstellungen.";
            }
        } else {
            // $lead['email'] ist nicht vorhanden oder keine gültige E-Mail-Adresse
            echo "Die E-Mail-Adresse ist nicht angegeben oder ungültig.";
        }
    }


?>

    <h3><?php esc_html_e('Additional Fields', 'apovoice') ?></h3>
    <?php if (is_array($expertOnlyPharmacies) && count($expertOnlyPharmacies) > 0) { ?>
        <table class="form-table">
            <tr>
                <th>
                    <label><?php esc_html_e('Name der Apotheke', 'apovoice') ?></label>
                </th>
                <td>
                    <input id="pharmacyName" type="text" name="pharmacyName" value="<?php echo $expertOnlyPharmacies_sorted['pharmacyName'] ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('Land der Apotheke', 'apovoice') ?></label>
                </th>
                <td>
                    <select id="pharmacyCountry" name="pharmacyCountry">
                        <option value="germany" <?php selected('germany' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>germany</option>
                        <option value="denmark" <?php selected('denmark' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>denmark</option>
                        <option value="poland" <?php selected('poland' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>poland</option>
                        <option value="czechRepublic" <?php selected('czechRepublic' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>czechRepublic</option>
                        <option value="austria" <?php selected('austria' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>austria</option>
                        <option value="switzerland" <?php selected('switzerland' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>switzerland</option>
                        <option value="france" <?php selected('france' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>france</option>
                        <option value="luxembourg" <?php selected('luxembourg' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>luxembourg</option>
                        <option value="belgium" <?php selected('belgium' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>belgium</option>
                        <option value="netherlands" <?php selected('netherlands' === $expertOnlyPharmacies_sorted['pharmacyCountry']) ?>>netherlands</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('Straße der Apotheke', 'apovoice') ?></label>
                </th>
                <td>
                    <input id="pharmacyStreet" type="text" name="pharmacyStreet" value="<?php echo $expertOnlyPharmacies_sorted['pharmacyStreet'] ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('Hausnummer der Apotheke', 'apovoice') ?></label>
                </th>
                <td>
                    <input id="pharmacyStreetNo" type="text" name="pharmacyStreetNo" value="<?php echo $expertOnlyPharmacies_sorted['pharmacyStreetNo'] ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('PLZ der Apotheke', 'apovoice') ?></label>
                </th>
                <td>
                    <input id="pharmacyZipCode" type="text" name="pharmacyZipCode" value="<?php echo $expertOnlyPharmacies_sorted['pharmacyZipCode'] ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('Stadt der Apotheke', 'apovoice') ?></label>
                </th>
                <td>
                    <input id="pharmacyCity" type="text" name="pharmacyCity" value="<?php echo $expertOnlyPharmacies_sorted['pharmacyCity'] ?>">
                </td>
            </tr>
        </table>
        <hr>
    <?php } ?>
    <table class="form-table">
        <!-- Form of address -->
        <?php if (isset($pun_arr[$upun])) { ?>
            <tr>
                <th>
                    <label><?php esc_html_e('PUN', 'apovoice') ?></label>
                </th>
                <td>
                    <input id="pun" type="text" name="registered_pharmacy_unique_number" value="<?php echo $pun_arr[$upun]->pharmacy_unique_number ?>">
                </td>
            </tr>
        <?php } ?>
        <tr>
            <th>
                <label><?php esc_html_e('Pending Redeemer', 'apovoice') ?></label>
            </th>
            <td>
                <label for="pending_redeemer">
                    <input type="hidden" name="is_pending" value="0">
                    <input id="pending_redeemer" type="checkbox" name="is_pending" value="1" <?php checked($is_pending === '1') ?>>
                </label>
            </td>
        </tr>
        <tr>
            <th>
                <label><?php esc_html_e('Form of address', 'apovoice') ?></label>
            </th>
            <td>
                <label for="form_of_address_mrs">
                    <input id="form_of_address_mrs" type="radio" name="form_of_address" value="mrs" <?php checked($form_of_address === 'mrs') ?>>

                    <?php esc_html_e('Mrs.', 'apovoice') ?>
                </label>

                <label for="form_of_address_mr">
                    <input id="form_of_address_mr" type="radio" name="form_of_address" value="mr" <?php checked($form_of_address === 'mr') ?>>

                    <?php esc_html_e('Mr.', 'apovoice') ?>
                </label>
            </td>
        </tr>
        <!-- Title -->
        <tr>
            <th>
                <label for="title"><?php esc_html_e('Title', 'apovoice') ?></label>
            </th>
            <td>
                <select id="title" name="title">
                    <option value="dr.dr." <?php selected($title === 'dr.dr.') ?>>
                        Dr. Dr.
                    </option>
                    <option value="dr.med.dent." <?php selected($title === 'dr.med.dent.') ?>>
                        Dr. med. Dent.
                    </option>
                </select>
            </td>
        </tr>
        <!-- Job -->
        <tr>
            <th>
                <label for="job"><?php esc_html_e('Job', 'apovoice') ?></label>
            </th>
            <td>
                <select id="job" name="job">
                    <option value="" disabled selected class="hidden">
                        Please choose...
                    </option>
                    <?php
                    foreach (apo_get_job_roles() as $option) {
                    ?>
                        <option value="<?php echo $option['value'] ?>" <?php selected($job === $option['value']) ?>>
                            <?php echo $option['text'] ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <!-- Working Since -->
        <tr>
            <th>
                <label for="working_since"><?php esc_html_e('Working since (Year)', 'apovoice') ?></label>
            </th>
            <td>
                <input id="working_since" type="text" name="working_since" id="working_since" value="<?= (isset($_POST['working_since']) && !empty($_POST['working_since'])) ? esc_html($_POST['working_since']) : esc_html($working_since) ?>">
            </td>
        </tr>
        <!-- Age -->
        <tr>
            <th>
                <label for="age"><?php esc_html_e('Age', 'apovoice') ?></label>
            </th>
            <td>
                <select id="age" name="age">
                    <option value="< 24" <?php selected($age === '< 24') ?>>
                        &lt; 18
                    </option>
                    <option value="25 - 34" <?php selected($age === '25 - 34') ?>>
                        18 - 25
                    </option>
                    <option value="35 - 44" <?php selected($age === '35 - 44') ?>>
                        26 - 35
                    </option>
                    <option value="45 - 54" <?php selected($age === '45 - 54') ?>>
                        36 - 50
                    </option>
                    <option value="55 - 64" <?php selected($age === '55 - 64') ?>>
                        51 - 65
                    </option>
                    <option value="65 +" <?php selected($age === '65 +') ?>>
                        66+
                    </option>
                </select>
            </td>
        </tr>
        <!-- Priorities -->
        <tr>
            <th>
                <label for="priorities"><?php esc_html_e('Priorities', 'apovoice') ?></label>
            </th>
            <td>
                <script>
                    const toggleOtherPriorityVisibility = () => {
                        const selectedOptions = document.getElementById('priorities').selectedOptions;
                        const isOthersSelected = Array.from(selectedOptions).some(option => option.value === 'others');

                        if (isOthersSelected) {
                            document.getElementById('other_priority').style.display = 'block';
                        } else {
                            document.getElementById('other_priority').style.display = 'none';
                        }
                    };

                    document.addEventListener('DOMContentLoaded', () => {
                        document.getElementById('priorities').addEventListener('change', () => {
                            toggleOtherPriorityVisibility();
                        });

                        toggleOtherPriorityVisibility();
                    });
                </script>

                <select id="priorities" name="priorities[]" multiple>
                    <option value="consulting" <?php selected(in_array('consulting', $priorities)) ?>>
                        <?php esc_html_e('Consulting', 'apovoice') ?>
                    </option>
                    <option value="purchasing" <?php selected(in_array('purchasing', $priorities)) ?>>
                        <?php esc_html_e('Purchasing', 'apovoice') ?>
                    </option>
                    <option value="productmanagement" <?php selected(in_array('productmanagement', $priorities)) ?>>
                        <?php esc_html_e('Productmanagement', 'apovoice') ?>
                    </option>
                    <option value="others" <?php selected(in_array('others', $priorities)) ?>>
                        <?php esc_html_e('Others', 'apovoice') ?>
                    </option>
                </select>

                <br>

                <input id="other_priority" name="other_priority" type="text" value="<?= $other_priority ?>" />
            </td>
        </tr>
        <!-- Tasks -->
        <tr>
            <th>
                <label for="tasks"><?php esc_html_e('Tasks', 'apovoice') ?></label>
            </th>
            <td>
                <select id="tasks" name="tasks[]" multiple>
                    <option value="none" <?php selected(in_array('none', $tasks)) ?>>
                        <?php esc_html_e('None', 'apovoice') ?>
                    </option>
                    <option value="purchasing" <?php selected(in_array('purchasing', $tasks)) ?>>
                        <?php esc_html_e('Purchasing', 'apovoice') ?>
                    </option>
                    <option value="nutrition" <?php selected(in_array('nutrition', $tasks)) ?>>
                        <?php esc_html_e('Nutrition', 'apovoice') ?>
                    </option>
                    <option value="homeopathy" <?php selected(in_array('homeopathy', $tasks)) ?>>
                        <?php esc_html_e('Homeopathy', 'apovoice') ?>
                    </option>
                    <option value="pain" <?php selected(in_array('pain', $tasks)) ?>>
                        <?php esc_html_e('Pain', 'apovoice') ?>
                    </option>
                    <option value="elderly_people" <?php selected(in_array('elderly_people', $tasks)) ?>>
                        <?php esc_html_e('Elderly people', 'apovoice') ?>
                    </option>
                    <option value="mother_and_child" <?php selected(in_array('mother_and_child', $tasks)) ?>>
                        <?php esc_html_e('Mother and child', 'apovoice') ?>
                    </option>
                    <option value="vitamins" <?php selected(in_array('vitamins', $tasks)) ?>>
                        <?php esc_html_e('Vitamins', 'apovoice') ?>
                    </option>
                </select>
            </td>
        </tr>
    </table>
    <div>
        <a href="<?php echo get_option('siteurl') . "/wp-admin"; ?>?page=apo-expert-points&user_id=<?php echo $user->ID ?>">Add Expert Points</a>
    </div>
    <div class="requestWrapper">
        <div tabindex="0" class="autocomplete">
            <label>Address Dropdown</label>
            <div class="input-wrapper">
                <input data-locale="<?php echo substr(get_locale(), 0, 2) ?>" type="text" class="search" />
                <div tabindex="0" class="results"></div>
            </div>
            <input name="expert_only_pharmacies" type="text" class="selected" readonly />
        </div>
        <div class="address">
            <label>Registration Address</label>
            <?php
            foreach (array_slice($gfentry, 0, 7) as $entry) {
            ?>
                <div><?php echo $entry->meta_value ?></div>
            <?php
            }
            ?>
            <div><button name="confirmationMail" type="submit">Send confirmation Mail</button></div>
        </div>
    </div>
<?php
}

add_action('show_user_profile', 'apo_show_extra_profile_fields');
add_action('edit_user_profile', 'apo_show_extra_profile_fields');

function apo_user_profile_validate_pun($post)
{
    if (isset($_POST['registered_pharmacy_unique_number'])) {
        $puns = new PUN();
        $pun_arr = array();
        foreach ($puns->queryResult() as $pun) {
            $pun_arr[$pun->pharmacy_unique_number] = $pun->id;
        }
        unset($puns);

        if (empty($_POST['registered_pharmacy_unique_number']) || in_array($_POST['registered_pharmacy_unique_number'], array_keys($pun_arr))) {
            return $pun_arr[$_POST['registered_pharmacy_unique_number']];
        }
        return false;
    }
    return true;
}

function apo_user_profile_validate_is_pending($post)
{
    return empty($_POST['is_pending']) || in_array($_POST['is_pending'], array('0', '1'));
}

function apo_user_profile_validate_form_of_address($post)
{
    return empty($_POST['form_of_address']) || in_array($_POST['form_of_address'], array('mrs', 'mr'));
}

function apo_user_profile_validate_title($post)
{
    return empty($_POST['title']) || in_array($_POST['title'], array('dr.dr.', 'dr.med.dent.'));
}

function apo_user_profile_validate_job($post)
{
    $job_arr = array_map(function ($job) {
        return $job['value'];
    }, apo_get_job_roles());
    return empty($_POST['job']) || in_array($_POST['job'], $job_arr);
}

function apo_user_profile_validate_working_since($post)
{
    return empty($_POST['working_since']) || (bool) preg_match('/^\d{4}$/', $_POST['working_since']);
}

function apo_user_profile_validate_age($post)
{
    return !empty($_POST['age']);
}

function apo_user_profile_validate_priorities($post)
{
    if (empty($_POST['priorities'])) {
        return true;
    }

    $valid_priorities = array(
        'consulting',
        'purchasing',
        'productmanagement',
        'others',
    );

    foreach ($post['priorities'] as $priority) {
        if (!in_array($priority, $valid_priorities)) {
            return false;
        }
    }

    if (in_array('others', $post['priorities']) && empty($post['other_priority'])) {
        return false;
    }

    return true;
}

function apo_user_profile_validate_tasks($post)
{
    if (empty($_POST['tasks'])) {
        return true;
    }

    $valid_tasks = array(
        'none',
        'purchasing',
        'nutrition',
        'homeopathy',
        'pain',
    );

    foreach ($post['tasks'] as $task) {
        if (!in_array($task, $valid_tasks)) {
            return false;
        }
    }

    return true;
}

function apo_user_profile_update_errors($errors, $update, $user)
{

    if (!apo_user_profile_validate_pun($_POST)) {
        $errors->add('pun_error', __('<strong>ERROR</strong>: The selected value for the PUN is invalid', 'apovoice'));
    }

    if (!apo_user_profile_validate_is_pending($_POST)) {
        $errors->add('is_pending_error', __('<strong>ERROR</strong>: The selected value for the Pending Redeemer is invalid', 'apovoice'));
    }

    // Form of address
    if (!apo_user_profile_validate_form_of_address($_POST)) {
        $errors->add('form_of_address_error', __('<strong>ERROR</strong>: The selected value for the Form of address is invalid', 'apovoice'));
    }

    // Title
    if (!apo_user_profile_validate_title($_POST)) {
        $errors->add('title_error', __('<strong>ERROR</strong>: The selected value for the Title is invalid', 'apovoice'));
    }

    // Job
    if (!apo_user_profile_validate_job($_POST)) {
        $errors->add('job_error', __('<strong>ERROR</strong>: The selected value for the Job is invalid', 'apovoice'));
    }

    // Working since
    if (!apo_user_profile_validate_working_since($_POST)) {
        $errors->add('working_since_error', __('<strong>ERROR</strong>: The entered value for Working since (year) is invalid, please use the full year eg. 2012.', 'apovoice'));
    }

    // Age
    if (!apo_user_profile_validate_age($_POST)) {
        $errors->add('age_error', __('<strong>ERROR</strong>: The selected value for Age is invalid', 'apovoice'));
    }

    // Priorities
    if (!apo_user_profile_validate_priorities($_POST)) {
        $errors->add('priorities_error', __('<strong>ERROR</strong>: The selected values for Priorities are invalid', 'apovoice'));
    }

    // Tasks
    if (!apo_user_profile_validate_tasks($_POST)) {
        $errors->add('tasks_error', __('<strong>ERROR</strong>: The selected values for Tasks are invalid', 'apovoice'));
    }
}

function apo_personal_options_update($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['confirmationMail'])) {
        return false;
    }

    if (isset($_POST['pharmacyName'])) {
        $expertOnlyPharmacies_arr = array(0 => null);
        $expertOnlyPharmacies_arr[0][] = ['title' => 'pharmacyName', 'value' => $_POST['pharmacyName']];
        $expertOnlyPharmacies_arr[0][] = ['title' => 'pharmacyCountry', 'value' => $_POST['pharmacyCountry']];
        $expertOnlyPharmacies_arr[0][] = ['title' => 'pharmacyStreet', 'value' => $_POST['pharmacyStreet']];
        $expertOnlyPharmacies_arr[0][] = ['title' => 'pharmacyStreetNo', 'value' => $_POST['pharmacyStreetNo']];
        $expertOnlyPharmacies_arr[0][] = ['title' => 'pharmacyZipCode', 'value' => $_POST['pharmacyZipCode']];
        $expertOnlyPharmacies_arr[0][] = ['title' => 'pharmacyCity', 'value' => $_POST['pharmacyCity']];

        update_user_meta($user_id, 'expert_only_pharmacies', json_encode($expertOnlyPharmacies_arr, JSON_UNESCAPED_UNICODE));
    }

    if (isset($_POST['expert_only_pharmacies']) && strlen(trim($_POST['expert_only_pharmacies'])) > 0) {
        update_user_meta($user_id, 'expert_only_pharmacies', $_POST['expert_only_pharmacies']);
        update_user_meta($user_id, 'has_updated_pharmacy_address', "1");
    }

    // Form of address
    if ($pun_id = apo_user_profile_validate_pun($_POST)) {
        update_user_meta($user_id, 'registered_pharmacy_unique_number', $pun_id);
    }

    // Form of address
    if (apo_user_profile_validate_is_pending($_POST)) {
        update_user_meta($user_id, 'is_pending', $_POST['is_pending']);
    }

    // Form of address
    if (apo_user_profile_validate_form_of_address($_POST)) {
        update_user_meta($user_id, 'form_of_address', $_POST['form_of_address']);
    }

    // Title
    if (apo_user_profile_validate_title($_POST)) {
        update_user_meta($user_id, 'title', $_POST['title']);
    }

    // Job
    if (apo_user_profile_validate_job($_POST)) {
        update_user_meta($user_id, 'job', $_POST['job']);
    }

    // Working Since
    if (apo_user_profile_validate_working_since($_POST)) {
        update_user_meta($user_id, 'working_since', $_POST['working_since']);
    }

    // Age
    if (apo_user_profile_validate_age($_POST)) {
        update_user_meta($user_id, 'age', $_POST['age']);
    }

    // Priorities
    if (apo_user_profile_validate_priorities($_POST)) {
        $priorities = $_POST['priorities'];

        if (in_array('others', $priorities)) {
            $priorities[] = $_POST['other_priority'];
        }

        update_user_meta($user_id, 'priorities', $priorities);
    }

    // Tasks
    if (apo_user_profile_validate_tasks($_POST)) {
        update_user_meta($user_id, 'tasks', $_POST['tasks']);
    }
}

add_action('user_profile_update_errors', 'apo_user_profile_update_errors', 10, 3);
add_action('personal_options_update', 'apo_personal_options_update', 10, 3);
add_action('edit_user_profile_update', 'apo_personal_options_update', 10, 3);


//User Activity Log

//Tablename: survey_user_results
function showUserActivityLog($user)
{

    echo '<h2>Completed Surveys</h2>';

    $SurveyLogTable = new Survey_Log_Table;
    $SurveyLogTable->display();


    echo '<h2>Completed Trainings</h2>';

    $TrainingLogTable = new Training_Log_Table;
    $TrainingLogTable->display();
}

add_action('show_user_profile', 'showUserActivityLog');
add_action('edit_user_profile', 'showUserActivityLog');


add_action('wp_ajax_apo_reset_survey', 'apo_reset_survey');

function apo_reset_survey()
{
    $user_id = intval($_POST['user_id']);
    $survey_id = intval($_POST['survey_id']);

    global $wpdb;

    $result = $wpdb->delete($wpdb->prefix . 'survey_user_results', array(
        'user_id' => $user_id,
        'survey_id' => $survey_id
    ));

    echo $result;
    wp_die();
}
