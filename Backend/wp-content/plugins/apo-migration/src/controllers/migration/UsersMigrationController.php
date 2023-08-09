<?php

namespace apo\migration\controllers\migration;

use apo\migration\utilities\Mapper;
use apo\migration\controllers\AbstractMigrationController;
use apo\migration\controllers\migration\ExpertPointsMigrationController;
use apo\migration\utilities\UploadTrait;

class UsersMigrationController extends AbstractMigrationController
{

    /**
     * @todo: Impement propper role mapping. german roles to INT roles
     */

    use Mapper, UploadTrait;

    /**
     * Migration Status Identifier in table
     */
    const MIGRATION_STATUS_IDENTIFIER = 'users_migrated';

    /**
     * Define files and directories
     */
    const FILE_PREFIX = 'users_';
    const DIRECTORY = 'users';
    const USER_ID_MAPPING_FILE_PREFIX = 'user_id_mapping_';

    /**
     * Defines start prefix of file
     */
    protected $userIdMappingFilePrefix = self::USER_ID_MAPPING_FILE_PREFIX;

    /**
     * Required first level user data keys for wp_insert_user()
     * @link https://developer.wordpress.org/reference/functions/wp_insert_user/
     */
    protected $wpInsertfirstLevelUserKeys = [
        'user_login',
        'user_pass',
        'user_nicename',
        'user_email',
        'user_url',
        'user_registered',
        'user_activation_key',
        'user_status',
        'display_name',
    ];

    /**
     * Required user meta keys for wp_insert_user()
     * @link https://developer.wordpress.org/reference/functions/wp_insert_user/
     */
    protected $wpInsertUserMetaKeys = [
        'nickname',
        'first_name',
        'last_name',
        'description',
        'role',
    ];

    /**
     * Maps the old meta key to the new meta key
     * old => new
     */
    protected $metaKeyMapping = [
        'anrede' => 'form_of_address',
        'titel' => 'title',
        'tatigkeit' => 'job',
        'experience' => 'working_since',
        'alter' => 'age',
        'aufgaben' => 'priorities',
        'schwerpunkte' => 'tasks',
        'last_login_time' => 'login_dates',
        'pharmacy' => 'pharmacy',
        'kundennummer' => 'pg_customer_number',
        'expert_code' => 'registered_expert_code',
        'mailchimp_sync_3f7171ce2f' => 'mailchimp_sync_3f7171ce2f',
        'mc4wp_sync_remote_email_address' => 'mc4wp_sync_remote_email_address',
        'mc4wp_sync_last_updated' => 'mc4wp_sync_last_updated',
    ];
    
    /**
     * Define custom meta key mapping
     * the key sets the custom property
     * the value set the key to merge 
     */
    protected $customPrioritiesAndTasks = [
        'aufgaben_custom' => 'priorities',
        'schwerpunkte_custom' => 'tasks',
    ];

    /**
     * Define custom meta key mapping
     * the key sets the custom property
     * the value set the key to merge 
     */
    protected $customPharmacyMapping = [
        'pharmacy_city' => 'pharmacyCity',
        'pharmacy_hausnummer' => 'pharmacyStreetNo',
        'pharmacy_land' => 'pharmacyCountry',
        'pharmacy_name' => 'pharmacyName',
        'pharmacy_plz' => 'pharmacyZipCode',
        'pharmacy_street' => 'pharmacyStreet',
    ];

    /**
     * All additional user meta keys
     * key holds the meta key
     * value indicates if its a unique value or not
     */
    protected $additionalMetaKeys = [
        'form_of_address' => true,
        'title' => true,
        'job' => true,
        'working_since' => true,
        'age' => true,
        'priorities' => true,
        'tasks' => true,
        'login_dates' => true,
        'primary_blog' => true,
        'profile_picture' => true,
    ];

    /**
     * add keys which are required to be special be mapped
     */
    protected $specialKeys = [
        'primary_blog',
        'form_of_address',
        'age',
        'login_dates',
        'job',
        'priorities',
        'tasks',
    ];


    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAndWrite()
    {
        $results = [];
        foreach ($this->countries as $key => $country) {
            $users = $this->migrationDB->get_results(
                "SELECT 
                    *
                FROM 
                    `mtjpt_users`
                LEFT JOIN `mtjpt_usermeta` 
                    ON `mtjpt_usermeta`.`user_id` = `mtjpt_users`.`ID`
                WHERE 
                    `mtjpt_usermeta`.`meta_key` = 'pharmacy_land' 
                    AND `mtjpt_usermeta`.`meta_value` = '{$country}'
                "
            );

            foreach ($users as $user) {
                $metaResults = $this->migrationDB->get_results(
                    "SELECT 
                        `mtjpt_usermeta`.`meta_key`,
                        `mtjpt_usermeta`.`meta_value`
                    FROM 
                        `mtjpt_usermeta`
                    WHERE `mtjpt_usermeta`.`user_id` = $user->ID
                    "
                );
    
                $userMeta = [];

                $userMeta['expert_code'] = null;
    
                foreach ($metaResults as $index => $metaObject) {
                    $userMeta[$metaObject->meta_key] = $metaObject->meta_value;
                }
    
                $user->meta = $userMeta;
            }

            $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}", $users);
    
            $results[$key] = sizeof($users) . ' users written in ' . $this->filePrefix . $key . '.json for ' . $country . '.';
        }

        return $this->printResults($results);
    }

    public function create()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->filePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {
            
                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $userIdMapping = [];
                    foreach ($this->readFileFromSubdirectory($this->directory, "{$this->filePrefix}{$countryKey}") as $user) {

                        // init and create new user
                        $newUser = [];
                        $newUser = $this->createWPInsertUserData($user);
                        $userId = $this->getUserIdOrCreateNew($user, $newUser);
                        // $userId = wp_insert_user($newUser);
                        $userIdMapping[$user['ID']] = $userId;

                        // init additional user data
                        $newMeta = [];
                        $customPrioritiesAndTasks = [];
                        $pharmacy = array(0 => null);

                        // checks if the current user meta has some required data
                        foreach ($user['meta'] as $metaKey => $metaValue) {
                            // check if the old key exists in user meta
                            if( array_key_exists($metaKey, $this->metaKeyMapping) ) {

                                // check if translated key is a special key
                                if( in_array($this->metaKeyMapping[$metaKey], $this->specialKeys) ) {
                                    $newMeta[$this->metaKeyMapping[$metaKey]] = $this->mapSpecialKey($this->metaKeyMapping[$metaKey], $metaValue);
                                } else {
                                    $newMeta[$this->metaKeyMapping[$metaKey]] = $metaValue;
                                }

                            }

                            // check if a custom meta key exists
                            if ( array_key_exists($metaKey, $this->customPrioritiesAndTasks) && !empty($metaValue)) {
                                $customPrioritiesAndTasks[$this->customPrioritiesAndTasks[$metaKey]] = $metaValue;
                            }

                            // check if a pharmacy meta key exists
                            if ( array_key_exists($metaKey, $this->customPharmacyMapping) ) {
                                $pharmacy[0][] = ['title' => $this->customPharmacyMapping[$metaKey], 'value' => ($metaKey == 'pharmacy_land' ? $this->mapCountry($metaValue) : $metaValue)];
                            }
                        }
                        // merge the custom values with the final key
                        foreach ($customPrioritiesAndTasks as $internationalKey => $germanValue) {
                            $newMeta[$internationalKey] =  array_merge( maybe_unserialize($newMeta[$internationalKey]), ['others'], [$germanValue] );
                        }

                        // merge single pharmacy values into one meta key
                        $newMeta['expert_only_pharmacies'] =  json_encode($pharmacy);

                        // add all required meta data which are missing in the user meta per default
                        foreach ($this->additionalMetaKeys as $key => $unique) {
                            if( !array_key_exists($key, $newMeta) ) {
                                $newMeta[$key] = $this->mapSpecialKey($key);
                            }
                        }
                        
                        $newUser['meta'] = $newMeta;

                        // // add all required meta data
                        $this->addUserMeta($userId, $newUser['meta']);

                        // update password to old hash
                        $this->updatePasssword($user['user_pass'], $userId);

                        // insert users expert points
                        (new ExpertPointsMigrationController($userId, $user['meta']['points_current']))->create();
                    }

                    $this->writeFileInSubdirectory($this->directory, "{$this->userIdMappingFilePrefix}{$countryKey}", [$userIdMapping]);

                switch_to_blog(1);

                $results[$countryKey] = "Added " . sizeof($userIdMapping) . " Users to {$country} \n";

            }

        }

        $this->setMigrationStatus();

        return $this->printResults($results);
    }

    public function remove()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->userIdMappingFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {
                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $deletedResults = [];
                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->userIdMappingFilePrefix}{$countryKey}")[0] as $oldId => $newId) {
                    $deletedResults[$newId] = wpmu_delete_user($newId);
                    (new ExpertPointsMigrationController($newId))->remove();
                }

                $success = array_filter($deletedResults, function ($value) { return $value; });

                switch_to_blog(1);

                $results[$countryKey] = "Removed " . sizeof($success) . " Users from {$country}. \n";
            } 
        }

        $this->revokeMigrationStatus();
        
        return $this->printResults($results);
    }

    protected function createWPInsertUserData($user)
    {
        foreach ( maybe_unserialize($user['meta']['mtjpt_capabilities'])  as $key => $value) {

            switch (trim($key)) {
                case 'administrator':
                case 'editor':
                case 'author':
                case 'contributor':
                case 'subscriber':
                    $role = $key;
                    continue;
                    break;

                case 'wick_team':
                case 'aussendienst':
                    $role = 'sales_rep';
                    continue;
                    break;
            
                case '10_eur':
                case 'customer-reusable-code':
                    $role = 'hcp';
                    continue;
                    break;

                case 'kunden_admin':
                    $role = 'pg_admin';
                    continue;
                    break;

                case 'online_customer':
                case 'customer':
                    $role = 'hcp_without_10_eur';
                    continue;
                    break;

                case 'inactive':
                    $role = 'blocked';
                    continue;
                    break;
            }
        }

        $user['meta']['role'] = $role;

        $userdata = array_intersect_key( (array) $user, array_flip($this->wpInsertfirstLevelUserKeys));
        $metadata = array_intersect_key( (array) $user['meta'], array_flip($this->wpInsertUserMetaKeys));

        return array_merge($userdata, $metadata);
    }

    protected function updatePasssword($password, $userId)
    {
        $this->db->update(
            $this->db->wpdb->users,
            array( 'user_pass' => $password ),
            array( 'ID' => $userId )
        );

        return $this;
    }

    protected function addUserMeta($userId, $metaData)
    {
         foreach ($metaData as $key => $value) {
            add_user_meta($userId, $key, $value, true);
         }

         return $this;
    }

    protected function addUserExpertPoints($userId, $oldUserObject)
    {
         return (new ExpertPointsMigrationController($userId, $oldUserObject))->create();
    }

    protected function getUserIdOrCreateNew($user, $newUser)
    {
        if(email_exists($user['user_email'])) {
            return get_user_by('email', $user['user_email'])->ID;
        }
        return wp_insert_user($newUser);
    }

    protected function getFilePathsFromCreateMode()
    {
        return $this->generateFilesPathsWrittenByCreateMode([
            $this->directory . '/' . $this->userIdMappingFilePrefix,
        ]);    
    }
}