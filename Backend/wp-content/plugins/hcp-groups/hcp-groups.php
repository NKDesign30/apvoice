<?php

/**
 * Plugin Name: HCP Groups
 * Description: Ermöglicht das Hochladen einer CSV-Datei zur Zuweisung von Benutzerrollen basierend auf E-Mail-Adressen.
 * Version: 1.0
 * Author: Niko
 */

defined('ABSPATH') or die('Direkter Zugriff verboten!');

include_once plugin_dir_path(__FILE__) . 'hcp-groups-list-table.php';

function hcp_groups_add_plugin_capabilities()
{
  $roles = array('administrator', 'editor', 'custom_role'); // Fügen Sie hier Ihre gewünschten Rollen hinzu
  foreach ($roles as $the_role) {
    $role = get_role($the_role);
    if ($role) {
      $role->add_cap('hcp_groups_view');
    }
  }
}
add_action('admin_init', 'hcp_groups_add_plugin_capabilities');

function hcp_groups_admin_menu()
{
  add_menu_page(
    'HCP Groups',
    'HCP Groups',
    'hcp_groups_view', // Verwenden Sie die neue Capability
    'hcp-groups',
    'hcp_groups_admin_page',
    'dashicons-groups',
    6
  );
}
add_action('admin_menu', 'hcp_groups_admin_menu');


wp_enqueue_script('admin-filter', plugin_dir_url(__FILE__) . 'js/admin-filter.js', array('jquery'), '1.0', true);
function hcp_groups_admin_page()
{
  // Verarbeitung der Löschaktion
  if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['user_id'])) {
    // Überprüfen der Nonce
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'hcp_delete_user_' . $_GET['user_id'])) {
      die('Sicherheitsüberprüfung fehlgeschlagen');
    }
    hcp_remove_user_from_group(intval($_GET['user_id']));
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['hcp_groups_file'])) {
    hcp_groups_process_file($_FILES['hcp_groups_file']);
  }

?>

  <div class="wrap">
    <h1>HCP Groups: CSV-Upload</h1>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="file" name="hcp_groups_file" required />
      <input type="submit" value="Upload CSV" class="button button-primary" />
    </form>

    <!-- CSV-Importer über der Tabelle -->
    <h2>Importierte Daten</h2>
    <?php
    // Lade deine CSS-Datei
    wp_enqueue_style('hcp-groups-css', plugin_dir_url(__FILE__) . 'hcp-groups.css');
    $list_table = new HCP_Groups_List_Table();
    $list_table->prepare_items();
    $list_table->display();
    ?>
  </div>
<?php
}


function hcp_groups_process_file($file)
{
  global $wpdb;

  if ($file['error'] !== UPLOAD_ERR_OK) {
    echo 'Fehler beim Upload.';
    return;
  }

  $handle = fopen($file['tmp_name'], 'r');
  if (!$handle) {
    echo 'Fehler beim Öffnen der Datei.';
    return;
  }

  fgetcsv($handle); // Kopfzeile überspringen

  while (($data = fgetcsv($handle)) !== FALSE) {
    $email = $data[0];
    $groups = explode(',', $data[1]); // Trennen der Gruppen

    $user = get_user_by('email', $email);
    if ($user) {
      foreach ($groups as $group) {
        $group_sanitized = strtolower(str_replace(' ', '_', trim($group)));
        if (in_array($group_sanitized, ['group_1', 'group_2', 'group_3', 'group_4', 'group_5', 'group_6', 'group_7', 'group_8', 'group_9', 'group_10'])) {
          $user->add_role($group_sanitized);

          $wpdb->insert(
            'wp_hcp_group',
            array(
              'user_id' => $user->ID,
              'role' => $group_sanitized
            ),
            array('%d', '%s')
          );
        }
      }
    }
  }

  fclose($handle);
  echo 'CSV-Datei erfolgreich verarbeitet.';
}


add_action('admin_menu', 'hcp_groups_admin_menu');


function hcp_groups_ajax_remove_role()
{
  // Sicherstellen, dass die Anfrage von einem autorisierten Benutzer kommt
  if (!current_user_can('manage_options')) {
    wp_die('Keine Berechtigung');
  }

  // Überprüfen, ob die notwendigen Daten vorhanden sind
  if (empty($_POST['user_id']) || empty($_POST['role'])) {
    wp_die('Benutzer-ID oder Rolle fehlt');
  }

  $user_id = intval($_POST['user_id']);
  $role = sanitize_text_field($_POST['role']);

  // Abrufen des Benutzerobjekts
  $user = get_user_by('id', $user_id);
  if (!$user) {
    wp_die('Benutzer nicht gefunden');
  }

  // Entfernen der Rolle vom Benutzer
  if (in_array($role, $user->roles)) {
    $user->remove_role($role);
    echo 'Rolle erfolgreich entfernt';
  } else {
    echo 'Benutzer hat diese Rolle nicht';
  }

  wp_die();
}
function hcp_remove_user_from_group($user_id)
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'hcp_group';

  // Zuerst die Rolle des Benutzers in WordPress entfernen
  $user = get_user_by('id', $user_id);
  if ($user) {
    // Holen Sie die Rolle aus Ihrer 'wp_hcp_group' Tabelle
    $role_to_remove = $wpdb->get_var($wpdb->prepare("SELECT role FROM $table_name WHERE user_id = %d", $user_id));

    // Entfernen der Rolle, wenn sie existiert
    if ($role_to_remove && in_array($role_to_remove, $user->roles)) {
      $user->remove_role($role_to_remove);
    }
  }

  // Dann den Eintrag aus der 'wp_hcp_group' Tabelle entfernen
  $wpdb->delete($table_name, ['user_id' => $user_id], ['%d']);
}

add_action('wp_ajax_remove_hcp_group', 'hcp_groups_ajax_remove_role');
