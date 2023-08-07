<style>
.apo-migration-process-handler,
.apo-collapse-handler {
    cursor: pointer;
}

.apo-arrow {
    transition: ease-in 300ms;
}
.apo-collapse-handler.active .apo-arrow {
    transform: rotate(-180deg);
}

.apo-button-link {
    color: #0073aa;
}

/* .button-secondary */

.apo-success {
    color: #31843f;
}

.apo-documentation {
    padding: .5rem .8rem;
    background: white;
    border: 1px solid #ccd0d4
}

.apo-documentation-section {
    margin-bottom: 2.5rem;
    max-width: 960px;
}
</style>
<div id="migration" class="wrap">
    <h1>Apovoice Application Migration</h1>

    <!-- notifications start -->
    <?php foreach ( $data['messageClasses'] as $key => $classes ): ?>
        <?php if ( array_key_exists( $key, $data['payload'] ) ): ?>
            <?php foreach ( $data['payload'][$key] as $message ): ?>
                <div class="<?= $classes ?>">
                    <p><?= $message ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (!$data['isDatabaseConnectionEstablished'] && $data['canFetchAndWrite']) : ?>
        <div class="error notice">
            <p>Failed to connect to migration database.</p> 
                <p>Update Connection in <strong>MigrationDatabaseConnector@instsance</strong>.</p>
                <p>To determine proper IP run 
                    <strong>docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' apovoice-migration_mysql_1</strong> 
                in your terminal.</p>
        </div>
    <?php endif; ?>

    <div class="notice-<?= $data['isGermanBlogAvailable'] ? 'success' : 'error'; ?> notice">
        <p>German Blog is <?= $data['isGermanBlogAvailable'] ? 'available' : 'not available'; ?></p>
    </div>
    <div class="notice-<?= $data['isAustriaBlogAvailable'] ? 'success' : 'error'; ?> notice">
        <p>Austrian Blog is <?= $data['isAustriaBlogAvailable'] ? 'available' : 'not available'; ?></p>
    </div>

    <?php if (!$data['canFetchAndWrite'] && $missings = $data['mapperFilesStatus']['missings']) : ?>
        <div class="error notice">
            <p>These Mapping Files are missing. Please execute the create action with caution, it can failed.</p>
            <?php foreach($missings as $missingFile) : ?>
                <p><?= $missingFile; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($data['mapperFilesStatus']['showDownloadButton']) : ?>
        <div class="notice-info notice">
            <p>These Mapping Files are ready to download</p>
            <?php foreach($data['mapperFilesStatus']['downloadables'] as $files) : ?>
                <p><?= $files; ?></p>
            <?php endforeach; ?>
        </div>

        <form 
            method="post"
            action="<?= esc_html( admin_url( 'admin-post.php' ) ) ?>"
            id="apo-donwload-migration-mapper-files-form"
        >
            <input type="hidden" name="page" value="application-migration">
            <input type="hidden" name="action" value="apo_migration_download_mapper_files_form">
            <input type="hidden" name="apo-downloadables" value="<?= implode(',', $data['mapperFilesStatus']['downloadables']); ?>">
            <?php wp_nonce_field( 'apo_migration_download_mapper_files', 'apo_migration_download_mapper_files_nonce' ); ?>
                
            <?php submit_button( 'Download' ); ?>
        </form>
    <?php endif; ?>

    <!-- notifications end -->

    <h3>Merges application state from apovoice DE/AT into the International data structure</h3>

    <?php include APO_MIGRATION_VIEWS_DIR . 'migration-guide.php'; ?>

    <form 
        method="post"
        action="<?= esc_html( admin_url( 'admin-post.php' ) ) ?>"
        id="apo-migration-form"
    >
        <input type="hidden" name="page" value="application-migration">
        <input type="hidden" name="action" value="apo_migration_process_merge_form">
        <?php wp_nonce_field( 'apo_migration_process_merge', 'apo_migration_process_merge_nonce' ); ?>
        
        <p class="submit">
            <input type="submit" name="submit" id="apo-migration-submit" class="button button-primary" value="Execute">
        </p>
        <input style="display: none;" type="text" name="apo-migration-class" id="apo-migration-class" value="" />
        <input style="display: none;" type="text" name="apo-migration-method" id="apo-migration-method" value="" />

        <?php foreach ($data['migrateables'] as $part => $migrateables) : ?>
            <h2>Migration Part <?= $part === 'part_one' ? '1' : ($part === 'part_two' ? '2' : '3'); ?></h2>
            <div class="top">

                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th
                                scope="col"
                                id="migration-type"
                                class="manage-column column-migration-type column-primary"
                            >
                                Migration Resource
                            </th>
                            <th
                                scope="col"
                                id="migration-fetch-write"
                                class="manage-column column-migration-fetch-write column-primary"
                            >
                                Fetch & Write
                            </th>
                            <th
                                scope="col"
                                id="migration-create"
                                class="manage-column column-migration-create column-primary"
                            >
                                Create from JSON-File
                            </th>
                            <th
                                scope="col"
                                id="migration-remove"
                                class="manage-column column-migration-remove column-primary"
                            >
                                Destroy created resource
                            </th>
                            <th
                                scope="col"
                                id="migration-move-to-azure"
                                class="manage-column column-migration-move-to-azure column-primary"
                            >
                                Move to Azure
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($migrateables as $migrateable) : ?>
                        <tr>
                            <td>
                                <?php if ( apo_has_run_migration($data['currentMigrationStatus'], $migrateable['migrationStatusIdentifier']) ) : ?>
                                    <span class="dashicons dashicons-yes apo-success"></span>
                                <?php endif; ?>
                                <?= $migrateable['displayName']; ?>
                            </td>
                            <td>
                                <?php if ( $data['canFetchAndWrite'] ) : ?>
                                <span data-migration-class="<?= $migrateable['class'] ?>" data-migration-method="fetchAndWrite" class="apo-migration-process-handler button-secondary">Lets go</span>
                                <?php else : ?>
                                    Only on localhost
                                    <span class="dashicons dashicons-no" style="color: #dc3232;"></span>
                                <?php endif; ?> 
                            </td>
                            <td>
                                <?php if ( apo_can_run_migration($data['currentMigrationStatus'], $migrateable['dependsOn']) ) : ?>

                                <?php $extraClass = ( apo_has_run_migration($data['currentMigrationStatus'], $migrateable['migrationStatusIdentifier']) ) ? 'apo-confirm' : null; ?>
                                <span 
                                    data-migration-class="<?= $migrateable['class'] ?>" 
                                    data-migration-method="create" 
                                    class="apo-migration-process-handler button-secondary <?= $extraClass; ?>"
                                >Create</span>
                            </td>
                                <?php else : ?>
                                    <span>Resource depends on:<br /><?= implode(', ', (array) $migrateable['dependsOn']); ?></span>
                                <?php endif; ?>
                            <td><span data-migration-class="<?= $migrateable['class'] ?>" data-migration-method="remove" class="apo-migration-process-handler button-secondary">Remove</span></td>
                            <td><span data-migration-class="<?= $migrateable['class'] ?>" data-migration-method="upload" class="apo-migration-process-handler button-secondary">Upload</span> </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </form>

</div>