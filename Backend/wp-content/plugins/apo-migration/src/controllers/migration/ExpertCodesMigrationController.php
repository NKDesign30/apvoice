<?php 

namespace apo\migration\controllers\migration;

use apo\expertcodes\models\ExpertCode;
use apo\migration\controllers\AbstractMigrationController;
use apo\migration\controllers\migration\UsersMigrationController;
use apo\migration\utilities\UploadTrait;

class ExpertCodesMigrationController extends AbstractMigrationController
{

    use UploadTrait;
    
    /**
     * Migration Status Identifier in table
     */
    const MIGRATION_STATUS_IDENTIFIER = 'expert_codes_migrated';

    /**
     * Define files and directories
     */
    const FILE_PREFIX = 'expert_codes_';
    const DIRECTORY = 'expert_codes';
    const CREATED_EXPERT_CODE_FILE_PREFIX = 'expert_codes_created_';
    
    /**
     * Define files
     */
    protected $createdExpertCodeFilePrefix = self::CREATED_EXPERT_CODE_FILE_PREFIX;
    protected $userIdMappingFilePrefix = UsersMigrationController::USER_ID_MAPPING_FILE_PREFIX;

    /**
     * Defines subdirectories
     */
    protected $usersDirectory = UsersMigrationController::DIRECTORY;

    /**
    * Creates a new instance of ExpertCodesMigrationController
    */
    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAndWrite()
    {
        $results = [];
        foreach ($this->countries as $key => $country) {

            $expertCodes = $this->migrationDB->get_results(
                "SELECT 
                    *
                FROM 
                    `mtjpt_aav_experten`
                WHERE 
                code != ''
                "
            );

            $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}", $expertCodes);

            $results[$key] =  sizeof($expertCodes) . " Expert-Codes was written in {$this->filePrefix}{$key}.json for {$country}\n";

        }

        return $this->printResults($results);
    }

    public function create()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->filePrefix,
            $this->usersDirectory . '/' . $this->userIdMappingFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {

                $createdVouchers = [];
                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $expertCodeModel = new ExpertCode();

                $userIdMapping = $this->readFileFromSubdirectory($this->usersDirectory, "{$this->userIdMappingFilePrefix}{$countryKey}")[0];

                $expertCodes = $this->readFileFromSubdirectory($this->directory, "{$this->filePrefix}{$countryKey}");

                $mappedExpertCodes = [];
                $tempCodes = [];
                // extract unique expert codes
                foreach ($expertCodes as $expertCode) {
                    if ( !in_array($expertCode['code'], $tempCodes) ) {
                        if( !empty($expertCode['code']) && !is_null($expertCode['code']) ) {
                            $mappedExpertCodes[] = $expertCode;
                        }
                        $tempCodes[] = $expertCode['code'];
                    }
                }

                $createdExpertCodes = [];

                // add expert codes
                foreach ($mappedExpertCodes as $expertCode) {
                    $record = $expertCodeModel->create([
                        'expert_code' => $expertCode['code'],
                        'sales_rep_user_id' => 0,
                        'usages' => $this->wasExpertCodeReusable($expertCodes, $expertCode['code']) ? null : 1,
                        'used' => $this->getUsedByCode($expertCodes, $expertCode['code']),
                    ]);

                    if ( !is_wp_error($record) ) {
                        $createdExpertCodes[] = $expertCode['code'];
                    }
                }

                $assignedExpertCodes = array_filter($expertCodes, function($expertCode) {
                    return $expertCode['uid'] != 0;
                });

                // assign expert codes to users
                foreach ($assignedExpertCodes as $assignedExpertCode) {
                    
                    if( array_key_exists( $assignedExpertCode['uid'], $userIdMapping ) ) {
                        update_user_meta( $userIdMapping[$assignedExpertCode['uid']] , 'registered_expert_code', $assignedExpertCode['code']);
                    }

                }

                $this->writeFileInSubdirectory($this->directory, "{$this->createdExpertCodeFilePrefix}{$countryKey}", $createdExpertCodes);

                $results[$key] = "Added " . sizeof($createdExpertCodes) . " Expert Codes to {$country}.\n";

                switch_to_blog(1);

            }

        }

        $this->setMigrationStatus();

        return $this->printResults($results);
    }

    public function remove()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->createdExpertCodeFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {

                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $expertCodeModel = new ExpertCode();

                $deletedResults = [];
                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->createdExpertCodeFilePrefix}{$countryKey}") as $expertCode) {
                    $deletedResults[] = $expertCodeModel->db->delete($expertCodeModel->table, ['expert_code' => $expertCode]);
                }
                $onlyDeletedRecords = array_filter($deletedResults);

                $results[$countryKey] = "Removed " .  sizeof($onlyDeletedRecords) . "/" . sizeof($deletedResults) . " Expert Codes from {$country}...\n";

                switch_to_blog(1);

            }
        }

        $this->revokeMigrationStatus();
        
        return $this->printResults($results);
    }

    protected function getUsedByCode($expertCodes, $code)
    {
        return sizeof( 
            array_filter($expertCodes, function($expertCode) use($code) {
                return $expertCode['code'] === $code;
             }) 
        );
    }

    protected function wasExpertCodeReusable($expertCodes, $code)
    {
         return (bool) sizeof( 
            array_filter($expertCodes, function($expertCode) use($code) {
                return $expertCode['code'] === $code && $expertCode['reusable'] == 1;
             }) 
        );
    }

    protected function getFilePathsFromCreateMode()
    {
        return $this->generateFilesPathsWrittenByCreateMode([
            $this->directory . '/' . $this->createdExpertCodeFilePrefix,
        ]);    
    }
            
}