# Before Start
> **Before you start any migration part, you have to have backup your complete production database!!!**

- Check if the german and austrian blog are available. You should see a state notification.

## Why we have split the migration into different pieces
Trainings and Surveys are content based resources. Because there is a content-modules gap between the DE/AT and INT Application, these content must be provided manualy. This can take time, maybe some days. After the content is provided, we can continue with part 2 - the user migration.
The user migration is the foundation of user specific results from part 3. We need the newly created user id's to map the old user results from surveys/trainings to the new created. This also applies to voucher and expert codes.

Keep in mind:
After part 1 is migrated, the DE/AT Application should freeze new content production to avoid differences.
Part 2 and 3 must run sequentially but on the same day respectively from the same mysql dump.

## Fetch & Write (local only)
*The Fetch & Write actions are designed to execute it only on a localhost.*
- Start a docker mysql container with the actual database dump from the german apovoice application. You find a *how to* in the [apovoice-migration repo][1] or just run `git clone pg-consumer@vs-ssh.visualstudio.com:v3/pg-consumer/GEO-APOVOICE-COM/apovoice-migration`

## Migration
1. Execute **.Fetch & Write**. action on your local environment for each migration resource sequentially. Each Fetch & Write action depends on the successfully created resource from his previous migration part. So you have to verify that you have these previous created id-mapping-json-files before you fetch and write.
2. Commit the newly created **.json** files from Fetch & Write to git and push it to production environment
3. Login to production environment and execute **Create** actions sequentially
4. **IMPORTANT!!!** On success execute the Upload. The create action has created some **id-mapping-json-file**, to persist these files, it is necessary to upload it to the azure storage

## Pitfalls
- The migration plugin creates a **wp_apo_migration_status** database table to document the successful parts. On deactivating the plugin, the table is dropped to stay the database clean. How ever, if you deactivate the plugin before you are done with all 3 migration parts, it can come to restrictions on depending migration resources even if the dependencies are already migrated. If this is the case, open the **wp_apo_migration_status** table and insert a **1** instead the default **0** value to desired resource.
- The create execution from json files can take a long time. The php ini **max_execution_time** should be is set to 600 seconds. If this is to short increase the value. If this still dosen't help, check the log files, maybe it depends on some azure settings.


## Notice
- It is neccessary to finish a complete migration part before you start the next one.
- The Remove action is to revert the newly created resource. Execute this only if you are got some issues or you know what you are doing.

[1]: https://pg-consumer.visualstudio.com/GEO-APOVOICE-COM/_git/apovoice-migration