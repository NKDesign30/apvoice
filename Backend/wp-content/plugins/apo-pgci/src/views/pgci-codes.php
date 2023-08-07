<?php if (isset($_GET['edit'])) {
    global $wpdb;

    $id = (int) $_GET['edit'];
    $sql = "SELECT * FROM `".$wpdb->get_blog_prefix($site_id)."apovoice_pgci` WHERE id = $id";
    $data = $wpdb->get_results($sql);
    if (isset($_POST['bga_id'])) {
        $wpdb->update(
            $wpdb->get_blog_prefix($site_id) . 'apovoice_pgci',
            array(
                'bga_id' => $_POST['bga_id'],
                'name' => $_POST['name'],
                'house_nr' => $_POST['house_nr'],
                'street' => $_POST['street'],
                'zip_code' => $_POST['zip_code'],
                'city' => $_POST['city'],
            ),
            array( 'id' => $id )
        );
        $data = $wpdb->get_results($sql);
    }
    ?>
  
    <div id="pun-codes" class="wrap">
        <h1><?= __( 'Manage PUN Codes', 'apo-pun' ) ?></h1>
        <form method="post">
            <table>
                <tr>
                    <td style="width: 150px"><label for="bga_id">bga id</label></td>
                    <td><input type="text" name="bga_id" value="<?= $data[0]->bga_id ?>" /></td>
                </tr>

                <tr>
                    <td style="width: 150px"><label for="name">name</label></td>
                    <td><input type="text" name="name" value="<?= $data[0]->name ?>" /></td>
                </tr>

                <tr>
                    <td style="width: 150px"><label for="house_nr">house number</label></td>
                    <td><input type="text" name="house_nr" value="<?= $data[0]->house_nr ?>" /></td>
                </tr>

                <tr>
                    <td style="width: 150px"><label for="street">street</label></td>
                    <td><input type="text" name="street" value="<?= $data[0]->street ?>" /></td>
                </tr>

                <tr>
                    <td style="width: 150px"><label for="zip_code">zip code</label></td>
                    <td><input type="text" name="zip_code" value="<?= $data[0]->zip_code ?>" /></td>
                </tr>

                <tr>
                    <td style="width: 150px"><label for="city">city</label></td>
                    <td><input type="text" name="city" value="<?= $data[0]->city ?>" /></td>
                </tr>

               
            </table>
            <?php submit_button( 'Save' ); ?> <a href="./admin.php?page=apo-pgci-codes">&laquo; Back</a>
        </form>
    </div>
<?php } else { ?>



<div id="pgci-codes" class="wrap">
    <h1><?= __( 'Manage PGCI Codes', 'apo-pgci' ) ?></h1>

    <?php foreach ( $data['messageClasses'] as $key => $classes ): ?>
        <?php if ( array_key_exists( $key, $data['payload'] ) ): ?>
            <?php foreach ( $data['payload'][$key] as $message ): ?>
                <div class="<?= $classes ?>">
                    <p><?= $message ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ( $data['can_manage'] ) : ?>
    <form
        method="post"
        action="<?= esc_html( admin_url( 'admin-post.php' ) ) ?>"
        enctype="multipart/form-data"
    >
        <h3><?= __( 'Import an Excel Spreadsheet (.xls, .xlsx) or Comma Separated Value (.csv) File', 'apo-pgci' ) ?></h3>

        <input
            accept=".xls,.xlsx,.csv"
            name="apo_pgci_codes_file"
            type="file"
        >
        <input type="hidden" name="action" value="apo_pgci_codes_form">

        <?php wp_nonce_field( 'apo_pgci_save_settings', 'apo_pgci_save_settings_nonce' ); ?>
        <?php submit_button( __( 'Import PGCI Codes', 'apo-pgci' ) ); ?>
    </form>
    <p><a class="exportReporting" href="pcgi-export.php" >Export PGCI Codes as CSV</a></p>
    <p><a class="exportReporting" href="pcgi-export_update.php" >Export PGCI Codes as CSV(for update)</a></p>

    <?php endif; ?>

    <div class="tablenav top">
        <form method="get">
            <p class="search-box">
                <input type="hidden" name="page" value="apo-pgci-codes">

                <input type="search" name="s" value="">
                <input type="submit" class="button" value="<?= __( 'Search PGCI\'s', 'apo-pgci' ) ?>">
            </p>
        </form>

        <?php if ( $data['can_manage'] ) : ?>
        <form
            method="post"
            action="<?= esc_html( admin_url( 'admin-post.php' ) ) ?>"
        >
            <input type="hidden" name="page" value="apo-pgci-codes">

            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text"><?= __( 'Bulk actions', 'apo-pgci' ) ?></label>
                <select name="action_type" id="bulk-action-selector-top">
                    <option value="-1"><?= __( 'Bulk actions', 'apo-pgci' ) ?></option>
                    <option value="remove"><?= __( 'Remove', 'apo-pgci' ) ?></option>
                </select>

                <input type="hidden" name="action" value="apo_pgci_bulk_action_form">

                <?php wp_nonce_field( 'apo_pgci_bulk_action', 'apo_pgci_bulk_action_nonce' ); ?>
                <input type="submit" class="button action" value="<?= __( 'Do action', 'apo-pgci' ) ?>">
            </div>
        <?php endif; ?>
    </div>
         
    <?php  
            
            
            $page = intval( isset($_GET["npage"]) ? $_GET["npage"] : 1 );
            // The number of records to display per page
$page_size = 100;

// Calculate total number of records, and total number of pages
$total_records = count($data['pgcis'] );
$total_pages   = ceil($total_records / $page_size);
if ($page > $total_pages) {
    $page = $total_pages;
}      
$offset = ($page - 1) * $page_size;
$display = array_slice($data['pgcis'] , $offset, $page_size);

            
            ?>

    <?php 
    
    // page links
$N = min($total_pages, 9);
$pages_links = array();

$tmp = $N;
if ($tmp < $page || $page > $N) {
    $tmp = 2;
}
for ($i = 1; $i <= $tmp; $i++) {
    $pages_links[$i] = $i;
}

if ($page > $N && $page <= ($total_pages - $N + 2)) {
    for ($i = $page - 3; $i <= $page + 3; $i++) {
        if ($i > 0 && $i < $total_pages) {
            $pages_links[$i] = $i;
        }
    }
}

$tmp = $total_pages - $N + 1;
if ($tmp > $page - 2) {
    $tmp = $total_pages - 1;
}
for ($i = $tmp; $i <= $total_pages; $i++) {
    if ($i > 0) {
        $pages_links[$i] = $i;
    }
}
    ?>

<?php $prev = 0; ?>
<?php foreach ($pages_links as $p) { ?>
    <?php if (($p - $prev) > 1) { ?>
        <a href="#">...</a>
    <?php } ?>
    <?php $prev = $p; ?>

    <?php
    $style_active = '';
    if ($p == $page) {
        $style_active = 'style="font-weight:bold"';
    }
    ?>

    <a  <?php echo $style_active; ?> href="admin.php?page=apo-pgci-codes&npage=<?php echo $p; ?>"><?php echo $p; ?></a>
<?php } ?>
    

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <?php if ( $data['can_manage'] ) : ?>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1"><?= __( 'Choose all', 'apo-pgci' ) ?></label><input id="cb-select-all-1" type="checkbox"></td>
                <?php endif; ?>

                <th
                    scope="col"
                    id="bga_id"
                    class="manage-column column-pgci-code column-primary"
                >
                    <?= __( 'Bga id', 'apo-pgci' ) ?>
                </th>
                <th
                    scope="col"
                    id="name"
                    class="manage-column column-name"
                >
                    <?= __( 'Name', 'apo-pgci' ) ?>
                </th>
                <th
                    scope="col"
                    id="pharmacy"
                    class="manage-column column-name"
                >
                    <?= __( 'Street', 'apo-pgci' ) ?>
                </th>
                <th
                    scope="col"
                    id="street"
                    class="manage-column column-name"
                >
                    <?= __( 'House number', 'apo-pgci' ) ?>
                </th>
                <th
                    scope="col"
                    id="zip"
                    class="manage-column column-name"
                >
                    <?= __( 'ZIP Code', 'apo-pgci' ) ?>
                </th>
                <th
                    scope="col"
                    id="city"
                    class="manage-column column-name"
                >
                    <?= __( 'City', 'apo-pgci' ) ?>
                </th>
                <th
                    scope="col"
                    id="created-at"
                    class="manage-column column-created-at"
                >
                    <?= __( 'Created At', 'apo-pgci' ) ?>
                </th>
                <th
                    scope="col"
                    id="edit"
                    class="manage-column column-created-at"
                >
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($display as $pgci) : ?>
                <tr id="pgci-code-<?= $pgci->pg_customer_id ?>">
                    <?php if ( $data['can_manage'] ) : ?>
                    <th scope="row" class="check-column">
                        <input id="cb-select-<?= $pgci->id ?>" type="checkbox" name="pgcis[]" value="<?= $pgci->id ?>">
                    </th>
                    <?php endif; ?>
                    <td><?= $pgci->bga_id ?></td>
                    <td><?= $pgci->name ?></td>
                    <td><?= $pgci->street ?></td>
                    <td><?= $pgci->house_nr ?></td>
                    <td><?= $pgci->zip_code ?></td>
                    <td><?= $pgci->city ?></td>
                    <td><?= $pgci->created_at ?></td>
                    <td> <a href="./admin.php?page=apo-pgci-codes&edit=<?= $pgci->id ?>">edit</a>   </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
     
    </table>
  

   

    
    <?php if ( $data['can_manage'] ) : ?>
    </form>
    <?php endif; ?>
</div>
<?php }  ?>