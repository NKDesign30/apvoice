<div class="apo-documentation">
    <h1 class="apo-collapse-handler">Migration Guide <span style="margin-top: 6px;" class="apo-arrow dashicons dashicons-arrow-down-alt2"></span> </h1>
    <div class="apo-collapsable">
        <div class="apo-documentation-section">
            <h2>Before Start</h2>
            <p>
                <strong>Before you start any migration part, you have to have backup your complete production database!!!</strong>
                <br />
                <ul class="ul-disc">
                    <li>Check if the german and austrian blog are available. You should see a state notification at top.</li>
                </ul>
            </p>
        </div>
        <div class="apo-documentation-section">
            <h2>Why we have split the migration into different pieces</h2>
            <p>
                Trainings and Surveys are content based resources. Because there is a content-modules gap between the DE/AT and INT Application, these content must be provided manualy. This can take time, maybe some days. After the content is provided, we can continue with part 2 - the user migration.
                The user migration is the foundation of user specific results from part 3. We need the newly created user id's to map the old user results from surveys/trainings to the new created. This also applies to voucher and expert codes.
            </p>
            <p>
                <strong>Keep in mind:</strong><br />
                After part 1 is migrated, the DE/AT Application should freeze new content production to avoid differences.
                Part 2 and 3 must run sequentially but on the same day respectively from the same mysql dump.
            </p>
        </div>
        <div class="apo-documentation-section">
            <h2>Fetch & Write (local only)</h2>
            <i>The Fetch & Write actions are designed to execute it only on a localhost.</i>
            <ul class="ul-disc">
                <li>Start a docker mysql container with the actual database dump from the german apovoice application. You find a <i>how to</i> in the <a href="https://pg-consumer.visualstudio.com/GEO-APOVOICE-COM/_git/apovoice-migration" target="_blank">apovoice-migration repo</a> or just run <strong>git clone pg-consumer@vs-ssh.visualstudio.com:v3/pg-consumer/GEO-APOVOICE-COM/apovoice-migration</strong></li>
            </ul>
        </div>

        <div class="apo-documentation-section">
            <h2>Migration</h2>
            <ol>
                <li>Execute <strong>Fetch & Write</strong> action on your local environment for each migration resource sequentially. Each Fetch & Write action depends on the successfully created resource from his previous migration part. So you have to verify that you have these previous created id-mapping-json-files before you fetch and write.</li>
                <li>Commit the newly created <strong>.json</strong> files from Fetch & Write to git and push it to production environment</li>
                <li>Login to production environment and execute <strong>Create</strong> actions sequentially.</li>
                <li><strong>IMPORTANT!!!</strong> On success execute the Upload. The create action has created some <strong>id-mapping-json-files</strong>, to persist these files, it is necessary to upload it to the azure storage</li>
            </ol>
        </div>

        <div class="apo-documentation-section">
            <h2>Pitfalls</h2>
            <ul class="ul-disc">
                <li>The migration plugin creates a <strong>wp_apo_migration_status</strong> database table to document the successful parts. On deactivating the plugin, the table is dropped to stay the database clean. How ever, if you deactivate the plugin before you are done with all 3 migration parts, it can come to restrictions on depending migration resources even if the dependencies are already migrated. If this is the case, open the <strong>wp_apo_migration_status</strong> table and insert a <strong>1</strong> instead the default <strong>0</strong> value to desired resource.</li>
                <li>The create execution from json files can take a long time. The php ini <strong>max_execution_time</strong> should be is set to 600 seconds. If this is to short increase the value. If this still dosen't help, check the log files, maybe it depends on some azure settings.</li>
            </ul>
        </div>

        <div class="apo-documentation-section">
            <h2>Notice</h2>
            <ul class="ul-disc">
                <li>It is neccessary to finish a complete migration part before you start the next one.</li>
                <li>The Remove action is to revert the newly created resource. Execute this only if you are got some issues or you know what you are doing.</li>
            </ul>
        </div>

    </div>
</div>