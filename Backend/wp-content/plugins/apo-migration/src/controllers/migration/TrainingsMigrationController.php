<?php 
namespace apo\migration\controllers\migration;

use apo\trng\cpt\Training;
use apo\trng\cpt\TrainingSeries;
use apo\migration\utilities\FieldsTrait;
use apo\migration\utilities\LessonsTrait;
use apo\migration\controllers\AbstractMigrationController;
use apo\migration\utilities\UploadTrait;

class TrainingsMigrationController extends AbstractMigrationController
{

    use FieldsTrait, LessonsTrait, UploadTrait;

    /**
     * Migration Status Identifier in table
     */
    const MIGRATION_STATUS_IDENTIFIER = 'trainings_migrated';

    /**
     * Define files and directories
     */
    const FILE_PREFIX = 'trainings_';
    const DIRECTORY = 'trainings';
    const TRAINING_ID_MAPPING_FILE_PREFIX = 'training_id_mapping_';
    const TRAINING_SERIE_ID_MAPPING_FILE_PREFIX = 'training_series_id_mapping_';
    const LESSON_UUID_MAPPING_FILE_PREFIX = 'lesson_uuid_mapping_';

    /**
     * Defines start prefix of file
     */
    protected $trainingIdMappingFilePrefix = self::TRAINING_ID_MAPPING_FILE_PREFIX;
    protected $trainingSeriesIdMappingFilePrefix = self::TRAINING_SERIE_ID_MAPPING_FILE_PREFIX;
    protected $lessonUuidMappingFilePrefix = self::LESSON_UUID_MAPPING_FILE_PREFIX;
    
    /**
     * Required first level post data keys for wp_insert_post()
     * @link https://developer.wordpress.org/reference/functions/wp_insert_post/
     */
    protected $wpInsertPostFirstLevelPostKeys = [
        'post_title',
        'post_status',
        'post_type',
        'post_date',
        'post_date_gmt',
        'post_modified',
        'post_modified_gmt',
    ];

    /**
    * Creates a new instance of TrainingsMigrationController
    */
    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAndWrite()
    {
         $results = [];

         $trainingSeries = $this->migrationDB->get_results(
            "SELECT 
                *
            FROM
                `mtjpt_posts`
            WHERE 
                `mtjpt_posts`.`post_type` = 'produkt' 
                AND `mtjpt_posts`.`post_status` = 'publish'
            "
         );

         foreach ($trainingSeries  as $series) {
    
             $seriesMeta = $this->getPostMetaData( $series->ID ) ;

             // extract trainings fields from meta results to determine associated trainings to the current product
             $associatedTrainingsKeyData = array_filter($seriesMeta, function ( $meta ) {
                return preg_match('/^trainings_\d+_(training_id|year)/', $meta);
             }, ARRAY_FILTER_USE_KEY);

             $groupedAssociatedTrainingsKeyData = [];

             // group extracted training fields to a multidimensional array
             foreach ($associatedTrainingsKeyData as $key => $value) {
                preg_match('/^trainings_(?<digit>\d+)_(?<identifier>(training_id|year))/', $key, $match);

                if(strpos($key, $match['identifier'])) {
                    $groupedAssociatedTrainingsKeyData[$match['digit']][$match['identifier']] = $value;
                }
             }

             // iterate over groupedAssociatedTrainingsKeyData and fetch whole post data by id
             foreach ($groupedAssociatedTrainingsKeyData as $trainingKeyData) {
                $associatedTraining = $this->getPostWithMetaData( $trainingKeyData['training_id']);

                $seriesMeta['associatedTrainings'][] = $associatedTraining;
             }

             $series->groupedAssociatedTrainingsKeyData = $groupedAssociatedTrainingsKeyData;
             $series->meta = $seriesMeta;
         }

         $austriaSpecificTrainings = array_filter($trainingSeries, function ($series) {
            return strpos($series->meta['associatedTrainings'][0]->meta['land_filter'], 'Österreich') !== false;
         });

         $austriaSpecificTrainingIds = array_column($austriaSpecificTrainings, 'ID');

         $germanTrainings = array_filter($trainingSeries, function ($series) use ($austriaSpecificTrainingIds) {
             return !in_array( $series->ID, $austriaSpecificTrainingIds );
         });

         $filteredTrainingSeriesForAustria = array_filter($trainingSeries, function($series) {
            return strpos($series->meta['associatedTrainings'][0]->meta['land_filter_exclude'], 'Österreich') === false;
         });

         $results = [];
         foreach ($this->countries as $key => $country) {

            if($key === 'de') {
                $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}", $germanTrainings);
                $results[$key] = sizeof($germanTrainings) . ' trainings was written in ' . $this->filePrefix . $key . '.json for ' . $country . '.';
            } else if($key === 'at') {
                $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}", $filteredTrainingSeriesForAustria);
                $results[$key] = sizeof($filteredTrainingSeriesForAustria) . ' trainings was written in ' . $this->filePrefix . $key . '.json for ' . $country . '.';
            } else {
                $results['undefined'] = $key . ' has not related data.';
            }
         }

         return $this->printResults($results);
    }

    /**
     * 
     * Creates Training Series with releated trainings
     */
    public function create()
    {
        $this->buildLessonKeys()
            ->preapreFields();
            
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->filePrefix,
        ])) {
            return 'Requireds file for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {

                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $trainingsSeriesIdMapping = [];
                $trainingIdMapping = [];
                $lessonUuidMapping = [];
                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->filePrefix}{$countryKey}") as $trainingSeries) {

                    $newTrainingSeries = [];
                    $newTrainingSeries = $this->createTrainingSeries($trainingSeries);

                    $trainingsSeriesIdMapping[$trainingSeries['ID']] = $newTrainingSeries['id'];

                    foreach ($trainingSeries['meta']['associatedTrainings'] as $training) {
                        $newTraining = [];
                        // verify that the same training does not inserted multiple times
                        if( !array_key_exists($training['ID'], $trainingIdMapping) ) {
                            $newTraining = $this->createTraining($training);
                            $trainingIdMapping[$training['ID']] = $newTraining['id'];

                            // get and insert lesson data per training
                            $lessonData = $this->getLessonData($training['meta']);
                            update_field($lessonData['selector'], $lessonData['value'], $newTraining['id']);

                            // map new training data and lesson uuids with old training id
                            // can be useful to identify lessons and answers
                            $lessonUuidMapping[$training['ID']] = [
                                'newTrainingId' => $newTraining['id'],
                                'lessonGermanNameUuidMapping' => $lessonData['lessonGermanNameUuidMapping'],
                            ];

                        }
                    }

                    // map associated trainings value for a acf repater field
                    $trainingsGroupValue = array_map(function($keyData) use ($trainingIdMapping) {
                        return [
                            $this->fields['training_id'] => $trainingIdMapping[$keyData['training_id']],
                            $this->fields['training_year'] => $keyData['year'],
                        ];
                    }, $trainingSeries['groupedAssociatedTrainingsKeyData']);


                    // Define ACF fields
                    $trainingsGroup = [
                        'selector' => $this->fields['training_group'],
                        'value' => $trainingsGroupValue
                    ];

                    // Define ACF fields
                    $informationsGroup = [
                        'selector' => $this->fields['informations_group'],
                        'value' => [
                            $this->fields['informations_name'] => strip_tags($trainingSeries['meta']['preview_title']),
                            $this->fields['informations_description'] => strip_tags($trainingSeries['meta']['preview_text']),
                        ],
                    ];

                    // insert ACF fields
                    update_field($trainingsGroup['selector'], $trainingsGroup['value'], $newTrainingSeries['id']);
                    update_field($informationsGroup['selector'], $informationsGroup['value'], $newTrainingSeries['id']);
                }

                $this->writeFileInSubdirectory($this->directory, "{$this->trainingSeriesIdMappingFilePrefix}{$countryKey}", [$trainingsSeriesIdMapping]);
                $this->writeFileInSubdirectory($this->directory, "{$this->trainingIdMappingFilePrefix}{$countryKey}", [$trainingIdMapping]);
                $this->writeFileInSubdirectory($this->directory, "{$this->lessonUuidMappingFilePrefix}{$countryKey}", [$lessonUuidMapping]);

                $results[$countryKey] = "Added " . sizeof($trainingsSeriesIdMapping) . " Training-Series to {$country}\n";
                $results[$countryKey] .= "Added " . sizeof($trainingIdMapping) . " Trainings to {$country}\n";

                switch_to_blog(1);
            }
        }

        $this->setMigrationStatus();

        return $this->printResults($results);
    }

    public function remove()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->trainingIdMappingFilePrefix,
            $this->directory . '/' . $this->trainingSeriesIdMappingFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {
                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $deletedResults = [];
                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->trainingIdMappingFilePrefix}{$countryKey}")[0] as $oldId => $newId) {
                    $deletedResults['training'][$newId] = wp_delete_post($newId, true);
                }

                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->trainingSeriesIdMappingFilePrefix}{$countryKey}")[0] as $oldId => $newId) {
                    $deletedResults['training_series'][$newId] = wp_delete_post($newId, true);
                }

                $successfullyRemovedTrainingSeries = array_filter($deletedResults['training_series'], function ($value) { return $value; });
                $successfullyRemovedTrainings = array_filter($deletedResults['training'], function ($value) { return $value; });

                switch_to_blog(1);

                $results[$countryKey] = "Removed " . sizeof($successfullyRemovedTrainingSeries) . " training series from {$country}. \n";
                $results[$countryKey] .= "Removed " . sizeof($successfullyRemovedTrainings) . " trainings from {$country}. \n";
            } 
        }

        $this->revokeMigrationStatus();

        return $this->printResults($results);
    }

    protected function createWPInsertPostData($post)
    {
        return array_intersect_key( (array) $post, array_flip($this->wpInsertPostFirstLevelPostKeys) );
    }

    protected function updatePostType($post, $postType)
    {
         if( array_key_exists('post_type', $post) ) {
             $post['post_type'] = $postType;
         }
         return $post;
    }

    protected function createTrainingSeries( $data )
    {
        $trainingSeries = $this->updatePostType($this->createWPInsertPostData($data), TrainingSeries::SLUG);
        $id = wp_insert_post($trainingSeries);
        return [
            'id' => $id,
            'data' => $trainingSeries,
        ];
    }

    protected function createTraining( $data )
    {
        $training = $this->updatePostType($this->createWPInsertPostData($data), Training::SLUG);
        $id = wp_insert_post($training);
        return [
            'id' => $id,
            'data' => $training,
        ];
    }

    protected function getFilePathsFromCreateMode()
    {
        return $this->generateFilesPathsWrittenByCreateMode([
            $this->directory . '/' . $this->trainingSeriesIdMappingFilePrefix,
            $this->directory . '/' . $this->trainingIdMappingFilePrefix,
            $this->directory . '/' . $this->lessonUuidMappingFilePrefix,
        ]);    
    }
    
}