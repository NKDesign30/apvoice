<?php

namespace apo\migration\controllers;

use awsm\wp\libraries\Controller;
use apo\migration\models\MigrationStatus;
use apo\migration\utilities\AzureMigrationFileUploader;
use apo\migration\controllers\migration\UsersMigrationController;
use apo\migration\controllers\migration\SurveysMigrationController;
use apo\migration\controllers\migration\TrainingsMigrationController;
use apo\migration\controllers\migration\ExpertCodesMigrationController;
use apo\migration\controllers\migration\VoucherCodeMigrationController;
use apo\migration\controllers\migration\QuizUserResultsMigrationController;
use apo\migration\controllers\migration\SurveyUserResultsMigrationController;
use apo\migration\utilities\MigrationDatabaseConnector;

class AdminViewController extends Controller
{

    /**
     * Migration Status Model
     */
    protected $migrationStatus;

    protected $currentMigrationStatus;

    public function __construct()
    {
        parent::__construct();
        $this->viewDirectory = APO_MIGRATION_VIEWS_DIR;

        $this->migrationStatus = new MigrationStatus();

        $this->currentMigrationStatus = $this->migrationStatus->showOne(1);
    }

    /**
     * Prepare the data for the bonago vouchers admin view
     * 
     * @return template 
     */
    public function migration()
    {
        // TODO: show propper hints in each section
        $data = [
            'migrateables' => $this->getMigrateables(),
            'currentMigrationStatus' => $this->currentMigrationStatus,
            'canFetchAndWrite' => $this->canFetchAndWrite(),
            'payload' => $this->getPayload(),
            'messageClasses' => $this->getMessageClasses(),
            'mapperFilesStatus' => $this->getMapperFilesStatus(),
            'isDatabaseConnectionEstablished' => MigrationDatabaseConnector::verifyConnection(),
            'isGermanBlogAvailable' => array_key_exists('de', TrainingsMigrationController::getCountryBlogMapper()),
            'isAustriaBlogAvailable' => array_key_exists('at', TrainingsMigrationController::getCountryBlogMapper()),
        ];

        return $this->view('migration', $data);
    }

    protected function canFetchAndWrite()
    {
         return $_SERVER['HTTP_HOST'] === 'localhost';
    }

    protected function getPayload()
    {
        $payload = unserialize( base64_decode( $_GET['payload'] ?? '' ) );
        return $payload ? $payload : [];
    }

    protected function getMessageClasses()
    {
        return [
            'infos' => 'updated notice',
            'errors' => 'error notice',
            'notices' => 'update-nag notice',
        ];
    }

    protected function getMigrateables()
    {
        return [
            'part_one' => [
                [
                    'displayName' => 'Trainings',
                    'class' => 'TrainingsMigrationController',
                    'dependsOn' => null,
                    'migrationStatusIdentifier' => TrainingsMigrationController::MIGRATION_STATUS_IDENTIFIER,
                ],
                [
                    'displayName' => 'Surveys',
                    'class' => 'SurveysMigrationController',
                    'dependsOn' => null,
                    'migrationStatusIdentifier' => SurveysMigrationController::MIGRATION_STATUS_IDENTIFIER,
                ],
            ],
            'part_two' => [
                [
                    'displayName' => 'User',
                    'class' => 'UsersMigrationController',
                    'dependsOn' => [
                        TrainingsMigrationController::MIGRATION_STATUS_IDENTIFIER, 
                        SurveysMigrationController::MIGRATION_STATUS_IDENTIFIER
                    ],
                    'migrationStatusIdentifier' => UsersMigrationController::MIGRATION_STATUS_IDENTIFIER,
                ],
            ],
            'part_three' => [
                [
                    'displayName' => 'Survey User Results',
                    'class' => 'SurveyUserResultsMigrationController',
                    'dependsOn' => [
                        SurveysMigrationController::MIGRATION_STATUS_IDENTIFIER, 
                        UsersMigrationController::MIGRATION_STATUS_IDENTIFIER
                    ],
                    'migrationStatusIdentifier' => SurveyUserResultsMigrationController::MIGRATION_STATUS_IDENTIFIER,
                ],
                [
                    'displayName' => 'Training Quiz Results',
                    'class' => 'QuizUserResultsMigrationController',
                    'dependsOn' => [
                        TrainingsMigrationController::MIGRATION_STATUS_IDENTIFIER, 
                        UsersMigrationController::MIGRATION_STATUS_IDENTIFIER
                    ],
                    'migrationStatusIdentifier' => QuizUserResultsMigrationController::MIGRATION_STATUS_IDENTIFIER,
                ],
                [
                    'displayName' => 'Voucher Codes',
                    'class' => 'VoucherCodeMigrationController',
                    'dependsOn' => [UsersMigrationController::MIGRATION_STATUS_IDENTIFIER],
                    'migrationStatusIdentifier' => VoucherCodeMigrationController::MIGRATION_STATUS_IDENTIFIER,
                ],
                [
                    'displayName' => 'Expert Codes',
                    'class' => 'ExpertCodesMigrationController',
                    'dependsOn' => [UsersMigrationController::MIGRATION_STATUS_IDENTIFIER],
                    'migrationStatusIdentifier' => ExpertCodesMigrationController::MIGRATION_STATUS_IDENTIFIER,
                ],
            ],
        ];
    }

    protected function getMapperFilesStatus()
    {
         $filePathsAndNames = [
            ExpertCodesMigrationController::DIRECTORY => ExpertCodesMigrationController::CREATED_EXPERT_CODE_FILE_PREFIX,
            SurveysMigrationController::DIRECTORY => SurveysMigrationController::SURVEY_ID_MAPPING_FILE_PREFIX,
            SurveyUserResultsMigrationController::DIRECTORY => SurveyUserResultsMigrationController::SURVEY_USER_RESULTS_ID_MAPPING_FILE_PREFIX,
            TrainingsMigrationController::DIRECTORY => [
                TrainingsMigrationController::TRAINING_SERIE_ID_MAPPING_FILE_PREFIX,
                TrainingsMigrationController::TRAINING_ID_MAPPING_FILE_PREFIX,
                TrainingsMigrationController::LESSON_UUID_MAPPING_FILE_PREFIX,
            ],
            UsersMigrationController::DIRECTORY => UsersMigrationController::USER_ID_MAPPING_FILE_PREFIX,
            VoucherCodeMigrationController::DIRECTORY => VoucherCodeMigrationController::CREATED_VOUCHERS_FILE_PREFIX,
         ];


         $showDownloadButton = false;
         $missings = [];
         $downloadables = [];

         foreach (TrainingsMigrationController::getCountryBlogMapper() as $countryKey => $country) {

            foreach ($filePathsAndNames as $path => $name) {

                if ( is_array( $name ) ) {
                    
                    foreach ($name as $fileName) {
                        
                        if ( file_exists( APO_MIGRATION_ASSETS . '/' . $path . '/' . $fileName . $countryKey . '.json' ) ) {
                            continue;
                        }
        
                        if ( (new AzureMigrationFileUploader)->blobExists($fileName . $countryKey . '.json') ) {
                            $showDownloadButton = true;
                            $downloadables[] = $path . '/' . $fileName . $countryKey . '.json';
                            continue;
                        }
        
                        $missings[] = $fileName . $countryKey . '.json';

                    }
                } else {

                    if ( file_exists( APO_MIGRATION_ASSETS . '/' . $path . '/' . $name . $countryKey . '.json' ) ) {
                        continue;
                    }
    
                    if ( (new AzureMigrationFileUploader)->blobExists($name . $countryKey . '.json') ) {
                        $showDownloadButton = true;
                        $downloadables[] = $path . '/' . $name . $countryKey . '.json';
                        continue;
                    }
    
                    $missings[] = $name . $countryKey . '.json';

                }

            }

        }

        return [
            'showDownloadButton' => $showDownloadButton,
            'missings' => $missings,
            'downloadables' => $downloadables,
        ];
    }

}