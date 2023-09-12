<?php
global $wpdb;
$sql2 = "SELECT * FROM wp_apovoice_roles";
$editable_roles = $wpdb->get_results($sql2);
$arr = array();
foreach ($editable_roles as $role) {
    $arr[$role->id] = $role->name;
}

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $sql = "SELECT * FROM `" . $wpdb->get_blog_prefix($site_id) . "apovoice_pharmacies` WHERE id = $id";
    $data = $wpdb->get_results($sql);


    if (isset($_POST['pharmacy_unique_number'])) {
        $post = $_POST['pharmacy_unique_number'];
        $wpdb->update(
            $wpdb->get_blog_prefix($site_id) . 'apovoice_pharmacies',
            array(
                'pharmacy_unique_number' => $_POST['pharmacy_unique_number'],
                'name' => $_POST['name'],
                'role_id' => $_POST['role']
            ),
            array('id' => $id)
        );
        $data = $wpdb->get_results($sql);
    }


?>
    <div id="pun-codes" class="wrap">
        <h1><?= __('Manage PUN Codes', 'apo-pun') ?></h1>
        <form method="post">
            <table>
                <tr>
                    <td style="width: 150px"><label for="pharmacy_unique_number">PUN Code</label></td>
                    <td><input type="text" name="pharmacy_unique_number" value="<?= $data[0]->pharmacy_unique_number ?>" /></td>
                </tr>
                <tr>
                    <td><label for="name">Name</label></td>
                    <td><input type="text" name="name" value="<?= $data[0]->name ?>" /></td>
                </tr>
                <tr>
                    <td><label for="roles">Roles</label></td>
                    <td><select name="role" id="roles">
                            <?php
                            foreach ($editable_roles as $role) {
                            ?>
                                <?php if ($role->id == $data[0]->role_id) { ?>
                                    <option selected value=<?= $role->id ?>><?= $role->name ?></option>
                                <?php  } else { ?>
                                    <option value=<?= $role->id ?>><?= $role->name ?></option>
                                <?php  }
                                ?>
                            <?php  }
                            ?>

                        </select></td>
                </tr>
            </table>
            <?php submit_button('Save'); ?> <a href="/wp-admin/admin.php?page=apo-pun-codes">&laquo; Back</a>
        </form>
    </div>
<?php } else { ?>

    <div id="pun-codes" class="wrap">
        <h1><?= __('Manage PUN Codes', 'apo-pun') ?></h1>

        <?php foreach ($data['messageClasses'] as $key => $classes) : ?>
            <?php if (array_key_exists($key, $data['payload'])) : ?>
                <?php foreach ($data['payload'][$key] as $message) : ?>
                    <div class="<?= $classes ?>">
                        <p><?= $message ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($data['can_manage']) : ?>
            <form method="post" action="<?= esc_html(admin_url('admin-post.php')) ?>" enctype="multipart/form-data">
                <h3><?= __('Import an Excel Spreadsheet (.xls, .xlsx) or Comma Separated Value (.csv) File', 'apo-pun') ?></h3>

                <input accept=".xls,.xlsx,.csv" name="apo_pun_codes_file" type="file">
                <input type="hidden" name="action" value="apo_pun_codes_form">

                <?php wp_nonce_field('apo_pun_save_settings', 'apo_pun_save_settings_nonce'); ?>
                <?php submit_button(__('Import PUN Codes', 'apo-pun')); ?>
            </form>
        <?php endif; ?>

        <div class="tablenav top">
            <form method="get">
                <p class="search-box">
                    <input type="hidden" name="page" value="apo-pun-codes">

                    <input type="search" name="s" value="">
                    <input type="submit" class="button" value="<?= __('Search PUN\'s', 'apo-pun') ?>">
                </p>
            </form>

            <?php if ($data['can_manage']) : ?>
                <form method="post" action="<?= esc_html(admin_url('admin-post.php')) ?>">
                    <input type="hidden" name="page" value="apo-pun-codes">

                    <div class="alignleft actions bulkactions">
                        <label for="bulk-action-selector-top" class="screen-reader-text"><?= __('Bulk actions', 'apo-pun') ?></label>
                        <select name="action_type" id="bulk-action-selector-top">
                            <option value="-1"><?= __('Bulk actions', 'apo-pun') ?></option>
                            <option value="remove"><?= __('Remove', 'apo-pun') ?></option>
                        </select>

                        <input type="hidden" name="action" value="apo_pun_bulk_action_form">

                        <?php wp_nonce_field('apo_pun_bulk_action', 'apo_pun_bulk_action_nonce'); ?>
                        <input type="submit" class="button action" value="<?= __('Do action', 'apo-pun') ?>">
                    </div>
                <?php endif; ?>
        </div>



        <?php


        $page = intval(isset($_GET["npage"]) ? $_GET["npage"] : 1);
        // The number of records to display per page
        $page_size = 100;

        // Calculate total number of records, and total number of pages
        $total_records = count($data['puns']);
        $total_pages   = ceil($total_records / $page_size);
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $page_size;
        $display = array_slice($data['puns'], $offset, $page_size);


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

            <a <?php echo $style_active; ?> href="admin.php?page=apo-pun-codes&npage=<?php echo $p; ?>"><?php echo $p; ?></a>
        <?php } ?>



        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>

                    <?php if ($data['can_manage']) : ?>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1"><?= __('Choose all', 'apo-pun') ?></label><input id="cb-select-all-1" type="checkbox"></td>
                    <?php endif; ?>

                    <th scope="col" id="pun-code" class="manage-column column-pun-code column-primary">
                        <?= __('PUN Code', 'apo-pun') ?>
                    </th>
                    <th scope="col" id="name" class="manage-column column-name">
                        <?= __('Name', 'apo-pun') ?>
                    </th>

                    <th scope="col" id="role" class="manage-column column-name">
                        Roles
                    </th>
                    <th scope="col" id="created-at" class="manage-column column-created-at">
                        <?= __('Created At', 'apo-pun') ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($display  as $pun) : ?>
                    <tr id="pun-code-<?= $pun->pharmacy_unique_number ?>">
                        <?php if ($data['can_manage']) : ?>
                            <th scope="row" class="check-column">
                                <input id="cb-select-<?= $pun->id ?>" type="checkbox" name="puns[]" value="<?= $pun->id ?>">
                            </th>
                        <?php endif; ?>
                        <td>
                            <a href="/wp-admin/admin.php?page=apo-pun-codes&edit=<?= $pun->id ?>">
                                <?= $pun->pharmacy_unique_number ?>
                            </a>
                        </td>
                        <td><?= $pun->name ?></td>
                        <?php
                        if (!isset($arr[$pun->role_id])) {
                            echo "Fehlende role_id: " . $pun->role_id . "<br>";
                        }
                        ?>
                        <td><?= isset($arr[$pun->role_id]) ? $arr[$pun->role_id] : 'N/A' ?></td>
                        <td><?= $pun->created_at ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <?php if ($data['can_manage']) : ?>
            </form>
        <?php endif; ?>
    </div>

<?php } ?>