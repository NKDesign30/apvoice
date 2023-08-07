<div id="reporting-settings" class="wrap">
    <h1><?= __( 'Reporting Settings', 'apo_reporting' ) ?></h1>
    <p><?= __( 'Reinsert daily statistical data for a specific date', 'apo_reporting' ) ?></p>
    <p><a class="exportReporting" href="reporting-export.php">Export Reporting as CSV</a></p>

    <?php foreach ( $data['messageClasses'] as $key => $classes ): ?>
        <?php if ( array_key_exists( $key, $data['payload'] ) ): ?>
            <?php foreach ( $data['payload'][$key] as $message ): ?>
                <div class="<?= $classes ?>">
                    <p><?= $message ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <form
        method="post"
        action="<?= esc_html( admin_url( 'admin-post.php' ) ) ?>"
    >

        <input type="hidden" name="action" value="apo_reporting_reinsert_daily_statistics_form">

        <?php wp_nonce_field( 'apo_reporting_reinsert_daily_statistics', 'apo_reporting_reinsert_daily_statistics_nonce' ); ?>

        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="start_date"><?= __( 'Start date', 'apo_reporting') ?></label></th>
                    <td><input name="apo_reporting_reinsert_daily_statistics_start_date" type="text" id="start_date" class="regular-text" placeholder="YYYY-MM-DD" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="end_date"><?= __( 'End date', 'apo_reporting') ?></label></th>
                    <td><input name="apo_reporting_reinsert_daily_statistics_end_date" type="text" id="end_date" class="regular-text" placeholder="YYYY-MM-DD" required></td>
                </tr>
            </tbody>
        </table>

        <?php submit_button( __( 'Run script', 'apo_reporting' ) ); ?>

    </form>

</div>