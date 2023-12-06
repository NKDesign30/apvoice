<?php
if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class HCP_Groups_List_Table extends WP_List_Table
{


  /**
   * Konstruktor für die Tabelle
   */
  public function __construct()
  {
    parent::__construct([
      'singular' => 'hcp_group', // Singular name of the item
      'plural'   => 'hcp_groups', // Plural name of the item
      'ajax'     => false // We won't support Ajax for this table
    ]);
    $this->process_bulk_action();
  }
  /**
   * Definiere die Spalten für die Tabelle
   */
  public function get_columns()
  {
    return [
      'cb'         => '<input type="checkbox" />',
      'user_login' => 'Username',
      'user_email' => 'E-Mail',
      'roles'       => 'Groups',
      'actions'    => 'Delete from the group'
    ];
  }
  protected function column_cb($item)
  {
    if (isset($item['ID'])) { // Verwenden Sie 'ID' anstelle von 'id'
      return sprintf(
        '<input type="checkbox" name="bulk-delete[]" value="%s" />',
        esc_attr($item['ID'])
      );
    } else {
      return ''; // Keine Checkbox anzeigen, wenn keine ID vorhanden ist
    }
  }



  public function get_bulk_actions()
  {
    return [
      'bulk-delete' => 'Delete'
    ];
  }


  public function process_bulk_action()
  {
    // Überprüfen der Nonce
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'bulk-' . $this->_args['plural'])) {
      return;
    }

    // Debugging-Ausgabe
    error_log('process_bulk_action aufgerufen. Aktion: ' . $this->current_action());

    global $wpdb;
    $table_name = $wpdb->prefix . 'hcp_group'; // Angenommen, dies ist Ihre Tabelle, die die Benutzerrollen speichert

    if ('bulk-delete' === $this->current_action()) {
      error_log('Bulk-delete Aktion wird verarbeitet.');

      if (isset($_REQUEST['bulk-delete']) && is_array($_REQUEST['bulk-delete'])) {
        error_log('Bulk-delete IDs: ' . implode(', ', $_REQUEST['bulk-delete']));

        $ids = array_map('intval', $_REQUEST['bulk-delete']);

        // Führen Sie für jede ID eine Aktion zur Entfernung des Benutzers aus der Gruppe durch
        foreach ($ids as $id) {
          // Hier fügen Sie die Logik ein, um den Benutzer aus der Gruppe zu entfernen
          // Beispiel: $wpdb->delete($table_name, ['user_id' => $id], ['%d']);
        }
      } else {
        // Optional: Fehlermeldung oder Logging hinzufügen, wenn keine IDs vorhanden sind
        error_log('Keine IDs zum Löschen in bulk-delete.');
      }
    }
  }





  public function get_search_query()
  {
    return isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
  }

  /**
   * Überschreiben Sie die search_box-Methode, um die Suchleiste zu generieren
   */
  public function search_box($text, $input_id)
  {
    if (empty($_REQUEST['s']) && !$this->has_items()) {
      return;
    }

    $input_id = $input_id . '-search-input';

    if (!empty($_REQUEST['orderby'])) {
      echo '<input type="hidden" name="orderby" value="' . esc_attr($_REQUEST['orderby']) . '" />';
    }
    if (!empty($_REQUEST['order'])) {
      echo '<input type="hidden" name="order" value="' . esc_attr($_REQUEST['order']) . '" />';
    }
    if (!empty($_REQUEST['post_mime_type'])) {
      echo '<input type="hidden" name="post_mime_type" value="' . esc_attr($_REQUEST['post_mime_type']) . '" />';
    }
    if (!empty($_REQUEST['detached'])) {
      echo '<input type="hidden" name="detached" value="' . esc_attr($_REQUEST['detached']) . '" />';
    }

    $search_value = $this->get_search_query();

    echo '<p class="search-box">';
    echo '<label class="screen-reader-text" for="' . $input_id . '">' . $text . ':</label>';
    echo '<input type="search" id="' . $input_id . '" name="s" value="' . esc_attr($search_value) . '" />';
    echo '<input type="submit" name="" id="search-submit" class="button" value="' . esc_attr__('Search Users') . '" />';
    echo '</p>';
  }
  function extra_tablenav($which)
  {
    if ($which == 'top') {
?>
      <div class="alignleft actions">
        <select name="group_filter" id="group_filter">
          <option value="">Show all groups</option>
          <?php for ($i = 1; $i <= 10; $i++) : ?>
            <option value="group_<?php echo $i; ?>" <?php selected('group_' . $i, $_REQUEST['group_filter'] ?? ''); ?>>Group <?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
        <?php submit_button('Filter', 'secondary', 'filter_action', false); ?>
      </div>
<?php
    }
  }

  /**
   * Verarbeitet die Daten für die Tabelle
   */
  public function prepare_items()
  {
    global $wpdb;

    $table_name = $wpdb->prefix . 'hcp_group';
    $users_table_name = $wpdb->prefix . 'users';

    $per_page = 20; // Anzahl der Einträge pro Seite

    // Initialisieren Sie die Abfrage mit dem Grundgerüst
    $query = "SELECT u.ID, u.user_login, u.user_email, GROUP_CONCAT(DISTINCT hcp.role SEPARATOR ',') AS roles
    FROM $table_name AS hcp
    JOIN $users_table_name AS u ON hcp.user_id = u.ID";


    // Berücksichtigen des Filters
    if (!empty($_REQUEST['group_filter'])) {
      $query .= $wpdb->prepare(" WHERE hcp.role = %s", $_REQUEST['group_filter']);
    }

    // Suchabfrage
    $search = $this->get_search_query();
    if (!empty($search)) {
      $query .= $wpdb->prepare(" AND (u.user_login LIKE '%%%s%%' OR u.user_email LIKE '%%%s%%')", $search, $search);
    }

    // Sortieren der Daten, wenn erforderlich
    $orderby = (!empty($_REQUEST['orderby'])) ? esc_sql($_REQUEST['orderby']) : 'user_login';
    $order = (!empty($_REQUEST['order'])) ? esc_sql($_REQUEST['order']) : 'asc';
    $query .= ' GROUP BY u.ID ORDER BY ' . $orderby . ' ' . $order;

    // Paginierung
    $total_items = $wpdb->get_var("SELECT COUNT(DISTINCT u.ID) FROM $table_name AS hcp JOIN $users_table_name AS u ON hcp.user_id = u.ID");
    $paged = $this->get_pagenum();
    $offset = ($paged - 1) * $per_page;

    $this->items = $wpdb->get_results($wpdb->prepare("$query LIMIT %d OFFSET %d", $per_page, $offset), ARRAY_A);

    $this->set_pagination_args([
      'total_items' => $total_items,
      'per_page'    => $per_page
    ]);

    $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
  }


  /**
   * Standardwert für die Spalten, wenn keine spezielle Spalte gefunden wird
   */
  protected function column_default($item, $column_name)
  {
    if ($column_name === 'roles') {
      return $this->format_role_names($item[$column_name]);
    }
    return $item[$column_name];
  }

  private function format_role_names($roles_string)
  {
    $roles = explode(',', $roles_string);
    $formatted_roles = array_map(function ($role) {
      return ucwords(str_replace('_', ' ', $role)); // Ersetzt Unterstriche durch Leerzeichen und macht den ersten Buchstaben jedes Wortes groß
    }, $roles);
    return implode(', ', $formatted_roles);
  }
  /**
   * Spalte für Aktionen
   */
  protected function column_actions($item)
  {
    $delete_nonce = wp_create_nonce('hcp_delete_user_' . $item['ID']); // Verwenden Sie 'ID' anstelle von 'user_id'
    $actions = [
      'delete' => sprintf(
        '<a href="?page=%s&action=%s&user_id=%s&_wpnonce=%s">Löschen</a>',
        esc_attr($_REQUEST['page']),
        'delete',
        absint($item['ID']), // Verwenden Sie 'ID' anstelle von 'user_id'
        $delete_nonce
      )
    ];
    return $this->row_actions($actions);
  }
}

// Funktion zur Anzeigen der Tabelle
function hcp_groups_list_table_page()
{
  $table = new HCP_Groups_List_Table();
  echo '<form id="hcp-group-form" method="post">';
  wp_nonce_field('bulk-' . $table->_args['plural']); // Fügen Sie die Nonce hinzu
  $table->prepare_items();
  $table->display(); // Zeigen Sie die Tabelle an
  echo '</form>';
}


// Hinzufügen der Admin-Seite
add_action('admin_menu', 'hcp_groups_menu');
