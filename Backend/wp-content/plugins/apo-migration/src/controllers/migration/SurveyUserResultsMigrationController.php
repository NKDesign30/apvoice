<?php 
namespace apo\migration\controllers\migration;

use apo\svy\models\Result as SurveyUserResult;
use apo\migration\controllers\AbstractMigrationController;
use apo\migration\controllers\migration\UsersMigrationController;
use apo\migration\controllers\migration\SurveysMigrationController;
use apo\migration\utilities\UploadTrait;

class SurveyUserResultsMigrationController extends AbstractMigrationController
{

    use UploadTrait;
    
    /**
     * Migration Status Identifier in table
     */
    const MIGRATION_STATUS_IDENTIFIER = 'survey_user_results_migrated';

    /**
     * Define files and directories
     */
    const FILE_PREFIX = 'survey_user_results_';
    const DIRECTORY = 'survey_user_results';
    const SURVEY_USER_RESULTS_ID_MAPPING_FILE_PREFIX = 'survey_user_results_ids_';

    /**
     * Define files
     */
    protected $surveyUserResultsIdMappingFilePrefix = self::SURVEY_USER_RESULTS_ID_MAPPING_FILE_PREFIX;
    protected $surveyIdMappingFilePrefix = SurveysMigrationController::SURVEY_ID_MAPPING_FILE_PREFIX;
    protected $userIdMappingFilePrefix = UsersMigrationController::USER_ID_MAPPING_FILE_PREFIX;

    /**
     * Defines subdirectories
     */
    protected $surveyDirectory = SurveysMigrationController::DIRECTORY;
    protected $usersDirectory = UsersMigrationController::DIRECTORY;

    /**
     * User result model
     */
    protected $surveyUserResultModel;

    /**
    * Creates a new instance of SurveyUserResultsMigrationController
    */
    public function __construct()
    {   
        parent::__construct();
    }


    /**
     * Fetch survey user results from german database
     * write to dedicated json files
     */
    public function fetchAndWrite()
    {
        $results = [];
        foreach ($this->countries as $key => $country) {

            $surveyIdMapping = $this->readFileFromSubdirectory($this->surveyDirectory, $this->surveyIdMappingFilePrefix . $key )[0];

            foreach ($surveyIdMapping as $oldSurveyId => $newSurveyId) {
                $userResults = $this->migrationDB->get_results(
                    "SELECT 
                        `mtjpt_postmeta`.`meta_value` as `survey_id`,
                        `mtjpt_modal_survey_participants_details`.`uid`,
                        `mtjpt_modal_survey_participants_details`.`postid`,
                        `mtjpt_modal_survey_participants_details`.`qid`,
                        `mtjpt_modal_survey_participants_details`.`aid`,
                        `mtjpt_modal_survey_participants`.`email`,
                        `mtjpt_modal_survey_questions`.`question`,
                        `mtjpt_modal_survey_answers`.`answer` as `user_answer`,
                        `mtjpt_users`.`ID` as `user_id`
                    FROM `mtjpt_postmeta`
                    LEFT JOIN 
                        `mtjpt_modal_survey_participants_details` 
                        ON `mtjpt_postmeta`.`meta_value` = `mtjpt_modal_survey_participants_details`.`sid`
                    LEFT JOIN 
                        `mtjpt_modal_survey_participants` 
                        ON `mtjpt_modal_survey_participants_details`.`uid` = `mtjpt_modal_survey_participants`.`autoid`
                    LEFT JOIN 
                        `mtjpt_modal_survey_questions` 
                        ON `mtjpt_postmeta`.`meta_value` = `mtjpt_modal_survey_questions`.`survey_id` 
                        AND `mtjpt_modal_survey_participants_details`.`qid` = `mtjpt_modal_survey_questions`.`id`
                    LEFT JOIN 
                        `mtjpt_modal_survey_answers` 
                        ON `mtjpt_postmeta`.`meta_value` = `mtjpt_modal_survey_answers`.`survey_id` 
                        AND `mtjpt_modal_survey_participants_details`.`qid` = `mtjpt_modal_survey_answers`.`question_id`
                        AND `mtjpt_modal_survey_participants_details`.`aid` = `mtjpt_modal_survey_answers`.`autoid`
                    LEFT JOIN `mtjpt_users` ON `mtjpt_modal_survey_participants`.`email` = `mtjpt_users`.`user_email`
                    WHERE 
                        `mtjpt_postmeta`.`post_id` = {$oldSurveyId}
                    AND `mtjpt_postmeta`.`meta_key` = 'survey_survey_id'
                    "
                );

                $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}_{$newSurveyId}", $userResults);
                $results[$key] = sizeof($userResults) . ' survey user results was written in ' . $this->filePrefix . $key . '.json for ' . $country . '.';

            }

        }

        return $this->printResults($results);
    }

    /**
     * Creates survey user results
     */
    public function create()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->filePrefix,
            $this->surveyDirectory . '/' . $this->surveyIdMappingFilePrefix,
            $this->usersDirectory . '/' . $this->userIdMappingFilePrefix,
        ])) {
            return 'Required files for this action are missing.';
        }
        
        $results = [];
        foreach ($this->countries as $countryKey => $country) {
            
            if ( $this->blogExists($countryKey) ) {
                
                switch_to_blog($this->countryBlogMapper[$countryKey]);
                $this->surveyUserResultModel = new SurveyUserResult();

                $surveyIdMapping = $this->readFileFromSubdirectory($this->surveyDirectory, $this->surveyIdMappingFilePrefix . $countryKey)[0];
                $userIdMapping = $this->readFileFromSubdirectory($this->usersDirectory, $this->userIdMappingFilePrefix . $countryKey )[0];

                $createdSurveyUserResults = [];
                foreach ($surveyIdMapping as $oldSurveyId => $newSurveyId) {

                    $resultsPerUser = [];
                    foreach ($this->readFileFromSubdirectory($this->directory, "{$this->filePrefix}{$countryKey}_{$newSurveyId}") as $userResult) {
                        if ( array_key_exists($userResult['user_id'], $userIdMapping) ) {
                            $resultsPerUser[$userResult['user_id']][] = $userResult;
                        }
                    }

                    foreach ($resultsPerUser as $oldUserId => $result) {

                        $computedResult = array_map(function($r) {
                            return [
                                'question' => $r['question'],
                                'answer' => is_numeric($r['aid']) ? $r['user_answer'] : substr($r['aid'], strpos($r['aid'], "|") + 1),
                                'is_legacy' => true,
                                'legacy_data' => [
                                    'survey_id' => $r['survey_id'],
                                    'post_id' => $r['postid'],
                                    'user_id' => $r['user_id'],
                                    'uid' => $r['uid'],
                                    'qid' => $r['qid'],
                                    'aid' => $r['aid'],
                                    'user_answer' => $r['user_answer'],
                                ],
                            ];
                        }, $result);
    
                        $createdSurveyUserResults[] = $this->surveyUserResultModel->create([
                            'user_id' => $userIdMapping[$oldUserId],
                            'survey_id' => $newSurveyId,
                            'result' => maybe_serialize(array_merge(
                                ['is_legacy' => true],
                                $computedResult,
                            )),
                            'is_complete' => true,
                        ]);
                    }

                }

                $this->writeFileInSubdirectory($this->directory, "{$this->surveyUserResultsIdMappingFilePrefix}{$countryKey}", array_column($createdSurveyUserResults, 'id'));

                $results[$countryKey] .= "Added " . sizeof($createdSurveyUserResults) . " Survey user results to {$country}\n";

                switch_to_blog(1);
            }
        }

        $this->setMigrationStatus();

        return $this->printResults($results);
    }

    /**
     * Remove previous created survey user results
     */
    public function remove()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->surveyUserResultsIdMappingFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {
                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $this->surveyUserResultModel = new SurveyUserResult();

                $deletedResults = [];
                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->surveyUserResultsIdMappingFilePrefix}{$countryKey}") as $resultId) {
                    $deletedResults[] = $this->surveyUserResultModel->db->delete($this->surveyUserResultModel->table, ['id' => $resultId]);
                }
                $onlyDeletedRecords = array_filter($deletedResults);

                $results[$countryKey] = sizeof($onlyDeletedRecords) . "/" . sizeof($deletedResults) . " survey user results was removed from {$country}...\n";

                switch_to_blog(1);
            } 
        }

        $this->revokeMigrationStatus();
        
        return $this->printResults($results);
    }

    protected function getFilePathsFromCreateMode()
    {
        return $this->generateFilesPathsWrittenByCreateMode([
            $this->directory . '/' . $this->surveyUserResultsIdMappingFilePrefix,
        ]);    
    }

}     
