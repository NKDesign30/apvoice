<div id="bonago-vouchers" class="wrap">
    <h1><?= __( 'Manage Bonago Vouchers', 'apovoice-bonago' ) ?></h1>

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
        <h3><?= __( 'Import an Excel Spreadsheet (.xls, .xlsx) or Comma Separated Value (.csv) File', 'apovoice-bonago' ) ?></h3>

        <input
            accept=".xls,.xlsx,.csv"
            name="apo_bonago_voucher_codes_file"
            type="file"
        >
        <input type="hidden" name="action" value="apo_bonago_voucher_codes_form">

        <?php wp_nonce_field( 'apo_bonago_voucher_codes_file_save_settings', 'apo_bonago_voucher_codes_file_save_settings_nonce' ); ?>
        <?php submit_button( __( 'Import Voucher Codes', 'apovoice-bonago' ) ); ?>
    </form>
    <?php endif; ?>

    <ul class="subsubsub" style="margin-bottom: 12px;">
        <li class="all">
            <a href="?page=apo-bonago" class="<?= apo_bonago_is_current_link('all') ?>">
                <?= __( 'All', 'apovoice-bonago') ?> <span class="count">(<?= $data['amount']['all']?>)</span>
            </a> | 
        </li>
        <li class="available">
            <a href="?page=apo-bonago&filter=available" class="<?= apo_bonago_is_current_link('available') ?>">
                <?= __( 'Available', 'apovoice-bonago') ?> <span class="count">(<?= $data['amount']['available']?>)</span>
            </a> |     
        </li>
        <li class="assigned">
            <a href="?page=apo-bonago&filter=assigned" class="<?= apo_bonago_is_current_link('assigned') ?>">
                <?= __( 'Assigned', 'apovoice-bonago') ?> <span class="count">(<?= $data['amount']['assigned']?>)</span>
            </a> |  
        </li>
        <li class="redeemed">
        <a href="?page=apo-bonago&filter=redeemed" class="<?= apo_bonago_is_current_link('redeemed') ?>">
            <?= __( 'Redeemed', 'apovoice-bonago') ?> <span class="count">(<?= $data['amount']['redeemed']?>)</span>
            </a>
        </li>
    </ul>

    <div class="tablenav top">
        <form method="get">
            <p class="search-box">
                <input type="hidden" name="page" value="apo-bonago">
                <input type="hidden" name="filter" value="<?= $data['filter'] ?>">

                <input type="search" name="s" value="">
                <input type="submit" class="button" value="<?= __( 'Search vouchers', 'apovoice-bonago' ) ?>">
            </p>
        </form>

        <?php if ( $data['can_manage'] ) : ?>
        <form 
            method="post"
            action="<?= esc_html( admin_url( 'admin-post.php' ) ) ?>"
        >
            <input type="hidden" name="page" value="apo-bonago">

            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text"><?= __( 'Bulk actions', 'apovoice-bonago' ) ?></label>
                <select name="action_type" id="bulk-action-selector-top">
                    <option value="-1"><?= __( 'Bulk actions', 'apovoice-bonago' ) ?></option>
                    <option value="remove"><?= __( 'Remove', 'apovoice-bonago' ) ?></option>
                </select>

                <input type="hidden" name="action" value="apo_bonago_bulk_action_form">

                <?php wp_nonce_field( 'apo_bonago_bulk_action', 'apo_bonago_bulk_action_nonce' ); ?>
                <input type="submit" class="button action" value="<?= __( 'Apply', 'apovoice-bonago' ) ?>">
            </div>
        <?php endif; ?>
    </div>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
            <?php if ( $data['can_manage'] ) : ?>
            <td 
                id="cb" 
                class="manage-column column-cb check-column"
            >
                <label class="screen-reader-text" for="cb-select-all-1"><?= __( 'Choose all', 'apovoice-bonago' ) ?></label><input id="cb-select-all-1" type="checkbox">
            </td>
            <?php endif; ?>
                <th
                    scope="col"
                    id="voucher-code"
                    class="manage-column column-voucher-code column-primary"
                >
                    <?= __( 'Voucher Code', 'apovoice-bonago' ) ?>
                </th>
                <th
                    scope="col"
                    id="user"
                    class="manage-column column-user"
                >
                    <?= __( 'User', 'apovoice-bonago' ) ?>
                </th>
                <th
                    scope="col"
                    id="user"
                    class="manage-column column-email"
                >
                    <?= __( 'Email', 'apovoice-bonago' ) ?>
                </th>
                <th
                    scope="col"
                    id="assigned"
                    class="manage-column column-assigned"
                >
                    <?= __( 'Assigned', 'apovoice-bonago' ) ?>
                </th>
                <th
                    scope="col"
                    id="redeemed"
                    class="manage-column column-redeemed"
                >
                    <?= __( 'Redeemed', 'apovoice-bonago' ) ?>
                </th>
                <th
                    scope="col"
                    id="assigned-at"
                    class="manage-column column-assigned-at"
                >
                    <?= __( 'Assigned At', 'apovoice-bonago' ) ?>
                </th>
                <th
                    scope="col"
                    id="redeemed-at"
                    class="manage-column column-redeemed-at"
                >
                    <?= __( 'Redeemed At', 'apovoice-bonago' ) ?>
                </th>
                <th
                    scope="col"
                    id="expires-at"
                    class="manage-column column-expires-at"
                >
                    <?= __( 'Expires At', 'apovoice-bonago' ) ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['vouchers'] as $voucher) : ?>
                <tr id="bonago-voucher-code-<?= $voucher->voucher_code ?>">
                    <?php if ( $data['can_manage'] ) : ?>
                    <th scope="row" class="check-column">
                        <?php if ($voucher->assigned === 'No') : ?>			
                        <input id="cb-select-<?= $voucher->id ?>" type="checkbox" name="vouchers[]" value="<?= $voucher->id ?>">
                        <?php endif; ?>
                    </th>
                    <?php endif; ?>
                    <td><?= $voucher->voucher_code?></td>
                    <td>
                        <a href="<?= $voucher->user['link'] ?>">
                            <?= $voucher->user['name'] ?>
                        </a>
                    </td>
                    <td>
                        <a href="mailto:<?= $voucher->user['email'] ?>">
                            <?= $voucher->user['email'] ?>
                        </a>
                    </td>
                    <td><?= $voucher->assigned?></td>
                    <td><?= $voucher->redeemed?></td>
                    <td><?= $voucher->assigned_at?></td>
                    <td><?= $voucher->redeemed_at?></td>
                    <td><?= $voucher->expires_at?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ( $data['can_manage'] ) : ?>
    </form>
    <?php endif; ?>
</div>