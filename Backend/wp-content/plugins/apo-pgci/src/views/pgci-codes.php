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
            </tr>
        </thead>
        <tbody>

            <?php foreach ($data['pgcis'] as $pgci) : ?>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ( $data['can_manage'] ) : ?>
    </form>
    <?php endif; ?>
</div>
