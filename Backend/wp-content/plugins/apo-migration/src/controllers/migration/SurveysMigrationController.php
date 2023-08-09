<?php 
namespace apo\migration\controllers\migration;

use apo\migration\controllers\AbstractMigrationController;
use apo\migration\utilities\surveys\SurveyFieldsTrait;
use apo\migration\utilities\surveys\SurveyChapterFactory;
use apo\migration\utilities\UploadTrait;
use apo\svy\cpt\Survey;

class SurveysMigrationController extends AbstractMigrationController
{
    use SurveyFieldsTrait, UploadTrait;

     /**
     * Migration Status Identifier in table
     */
    const MIGRATION_STATUS_IDENTIFIER = 'surveys_migrated';

    /**
     * Define files and directories
     */
    const FILE_PREFIX = 'surveys_';
    const DIRECTORY = 'surveys';
    const SURVEY_ID_MAPPING_FILE_PREFIX = 'survey_id_mapping_';

    /**
     * Define files
     */
    protected $surveyIdMappingFilePrefix = self::SURVEY_ID_MAPPING_FILE_PREFIX;

    const DEFAULT_GERMAN_QUESTION_TYPE = 'default';
    const OPEN_GERMAN_QUESTION_TYPE = 'open';

    const DEFAULT_GERMAN_QUESTION_TYPE_CHOICES = ['Ja', 'Nein'];

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
    * Creates a new instance of SurveysMigrationController
    */
    public function __construct()
    {   
        parent::__construct();
    }

    public function fetchAndWrite()
    {
         $surveys = $this->migrationDB->get_results(
            "SELECT 
                *
            FROM
                `mtjpt_posts`
            WHERE 
                `mtjpt_posts`.`post_type` = 'umfrage' 
                AND `mtjpt_posts`.`post_status` = 'publish'
            "
         );

         // iterate over all survey posts
        foreach ($surveys as $survey) {

            // fetch associated meta data
            $surveyMeta = $this->getPostMetaData( $survey->ID );

            // extract associated survey id from the modal survey plugin
            $attachedSurveyId = $surveyMeta['survey_survey_id'];

            // fetch associated questions with the survey from the modal survey plugin
            $questions = $this->getQuestions($attachedSurveyId);

            // extract chapter fields from meta results to create new chapters
            $sectionData = array_filter($surveyMeta, function ( $meta ) {
            return preg_match('/^survey_step_\d+_section_\w+(text|question)/', $meta);
            }, ARRAY_FILTER_USE_KEY);

            // group data by steps
            $groupedSectionData = [];
            foreach ($sectionData as $key => $value) {
                preg_match('/^survey_step_(?<chapter>\d+)_section_\w+(?<identifier>(text|question))/', $key, $match);
                if(strpos($key, $match['identifier'])) {
                    if($match['identifier'] === 'question') {
                        $groupedSectionData[$match['chapter']][$match['identifier']] = maybe_unserialize($value);
                    } else {
                        $groupedSectionData[$match['chapter']][$match['identifier']] = $value;
                    }
                }
            }

            // allocate steps to chapters
            $chapters = [];
            foreach ($groupedSectionData as $chapter => $data) {

                // it must be a text paragraph
                if (count($data) === 1 && array_key_exists('text', $data)) {
                    $chapters[$chapter][] = [
                        'type' => 'text-paragraph',
                        'value' => strip_tags($data['text']),
                    ];
                } else if ( array_key_exists('text', $data) ) {
                    $chapters[$chapter]['question'] = strip_tags($data['text']);
                } 

                if ( array_key_exists('question', $data)) {
                    foreach ($data['question'] as $questionId) {
                        // fetch associated answer options for given survey questions from the modal survey plugin
                        $answers = $this->getAnswers($attachedSurveyId, $questionId);

                        // get the current question by question id
                        $theQuestion = array_filter($questions, function ( $q ) use($questionId) {
                            return $q->question_id === $questionId;
                        });

                        // Remove hidden answer options
                        $filteredAnswers = array_values(array_filter($answers, function($a) {
                            return maybe_unserialize($a->aoptions)[8] == 0;
                        }));

                        
                        $options = [
                            'question' => strip_tags(array_column($theQuestion, 'question')[0]),
                            'values' => array_column($filteredAnswers, 'answer')
                        ];
                        $type = maybe_unserialize(array_column($filteredAnswers, 'aoptions')[0])[0];

                        $chapters[$chapter][] = [
                            'type' => $this->identifyQuestionType(['options' => $options['values'], 'type' => $type]),
                            'options' => $options,
                        ];
                    }
                }

            }

            // re-structure chapters
            foreach ($chapters as &$chapter) {

                // save propper chapter module data temporary in this array, apply it at the and gto $chatper
                $tempChapter = [];

                // catch unidentified modules and convert it to a text paragraph
                $tempQuestion = null;
                
                foreach ($chapter as $module) {
                    if(is_string($module)) {
                        $tempQuestion = $module;
                    } else if ($module['type'] === 'rating') {
                        // create a placeholder to allocate ratings afterwards
                        $tempChapter['__RATING_PLACEHOLDER__'] = 'ADD HERE RATING MODULES';
                    } else {
                        $tempChapter[] = $module;
                    }
                }

                // collect rating modules
                $filteredRatingModules = array_values(array_filter($chapter, function ($c) {
                    return $c['type'] === 'rating';
                }));

                // if rating modules, re-create it to one module with n items
                if($filteredRatingModules) {
                    
                    $options = array_map( function($rating) use ($tempQuestion) {
                        return [
                            'headline' => !is_null($tempQuestion) ? $rating['options']['question'] : $tempQuestion,
                            'items' => $rating['options']['values'],
                        ];
                    }, $filteredRatingModules);

                    $mappedRatingModules = [
                        'type' => 'rating',
                        'question' => sizeof($filteredRatingModules) === 1 ? $filteredRatingModules[0]['options']['question'] : $tempQuestion,
                        'options' => $options,
                    ];

                    if(array_key_exists('__RATING_PLACEHOLDER__', $tempChapter)) {
                        array_unshift($tempChapter, $mappedRatingModules);
                        unset($tempChapter['__RATING_PLACEHOLDER__']); 
                    } else {
                        $tempChapter[] = $mappedRatingModules;
                    }
                } else if ( !is_null ($tempQuestion) ) {
                    array_unshift($tempChapter, [
                        'type' => 'text-paragraph',
                        'value' => $tempQuestion,
                        ]);
                }

                $allNotRatingModules = array_diff($chapter, $filteredRatingModules);

                $chapter = $tempChapter;
            }
            $survey->meta = $surveyMeta;
            $survey->chapters = $chapters;
            // $survey->groupedSectionData = $groupedSectionData;
        }

        $germanSpecificSurveys = array_filter($surveys, function ($survey) {
            return strpos($survey->meta['land_filter'], 'Österreich') === false;
        });

        $results = [];
         foreach ($this->countries as $key => $country) {

            if($key === 'de') {
                $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}", $germanSpecificSurveys);
                $results[$key] = sizeof($germanSpecificSurveys) . ' surveys was written in ' . $this->filePrefix . $key . '.json for ' . $country . '.';
            } else if($key === 'at') {
                $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}", $surveys);
                $results[$key] = sizeof($surveys) . ' surveys was written in ' . $this->filePrefix . $key . '.json for ' . $country . '.';
            } else {
                $results['undefined'] = $key . ' has not related data.';
            }
         }

         return $this->printResults($results);
    }

    /**
     * 
     * Creates surveys
     */
    public function create()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->filePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];

        $this->generateSurveyFields();

        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {

                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $surveyIdMapping = [];
                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->filePrefix}{$countryKey}") as $survey) {

                    $newSurvey = [];
                    $newSurvey = $this->createSurvey($survey);
                    
                    // set survey description
                    if( array_key_exists('description', $survey['meta']) ) {
                        update_field($this->surveyFields['survey_meta_description'], $survey['meta']['description'], $newSurvey['id']);
                    }

                    // set survey duration
                    if( array_key_exists('time_to_pass', $survey['meta']) ) {
                        update_field($this->surveyFields['survey_meta_duration_group'],[
                            $this->surveyFields['survey_meta_duration_time'] => $survey['meta']['time_to_pass'],
                            $this->surveyFields['survey_meta_duration_type'] => 'min'
                        ], $newSurvey['id']);
                    }
                    
                    // set survey points
                    if( array_key_exists('points', $survey['meta']) ) {
                        update_field($this->surveyFields['survey_meta_points'], $survey['meta']['points'], $newSurvey['id']);
                    }

                    // set survey expire date
                    if( array_key_exists('expires_at', $survey['meta']) ) {
                        update_field($this->surveyFields['survey_meta_expires_at'], $survey['meta']['expires_at'], $newSurvey['id']);
                    }

                    try {
                        $chapters = (new SurveyChapterFactory($survey['ID']))->getValues();
                    } catch(\Exception $error) {
            
                    }

                    // set chapters
                    if ( $chapters ) {
                        update_field($this->surveyFields['survey_chapters_group'], $chapters, $newSurvey['id']);
                    }
                    
                    $surveyIdMapping[$survey['ID']] = $newSurvey['id'];

                }

                $this->writeFileInSubdirectory($this->directory, "{$this->surveyIdMappingFilePrefix}{$countryKey}", [$surveyIdMapping]);

                $results[$countryKey] = "Added " . sizeof($surveyIdMapping) . " Surveys to {$country}\n";

                switch_to_blog(1);

            }

        }

        $this->setMigrationStatus();

        return $this->printResults($results);
    }

    public function remove()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->surveyIdMappingFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {
                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $deletedResults = [];
                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->surveyIdMappingFilePrefix}{$countryKey}")[0] as $oldId => $newId) {
                    $deletedResults[] = wp_delete_post($newId, true);
                }

                switch_to_blog(1);
                $results[$countryKey] = "Removed " . sizeof($deletedResults) . " surveys from {$country}. \n";
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
        $post['post_type'] = $postType;
        return $post;
    }

    protected function createSurvey( $data )
    {
        $survey = $this->updatePostType($this->createWPInsertPostData($data), Survey::SLUG);
        $id = wp_insert_post($survey);
        return [
            'id' => $id,
            'data' => $survey,
        ];
    } 

    /**
     * Convert the de/at question type into INT question type
     * @param array $answers holds answer options and a type key
     * @return string
     */
    protected function identifyQuestionType($answers)
    {
        if($answers['type'] === self::DEFAULT_GERMAN_QUESTION_TYPE && count( array_intersect(self::DEFAULT_GERMAN_QUESTION_TYPE_CHOICES, $answers['options']) ) === 2) {
            return 'choice-single';
        } else if($answers['type'] === self::DEFAULT_GERMAN_QUESTION_TYPE) {
            return 'rating';
        } else if ($answers['type'] === self::OPEN_GERMAN_QUESTION_TYPE)  {
            return 'answer-single-line';
        } else {
            return $answers['type'];
        }
    }

    protected function getQuestions($surveyId)
    {
        return $this->migrationDB->get_results(
            "SELECT 
                `mtjpt_modal_survey_questions`.`question`,
                `mtjpt_modal_survey_questions`.`id` as `question_id`
            FROM 
                `mtjpt_modal_survey_questions`
            WHERE 
            `mtjpt_modal_survey_questions`.`survey_id` = {$surveyId}
             "
         );
    }

    protected function getAnswers($surveyId, $questionId)
    {
        return $this->migrationDB->get_results(
            "SELECT
                `mtjpt_modal_survey_answers`.`question_id`,
                `mtjpt_modal_survey_answers`.`answer`,
                `mtjpt_modal_survey_answers`.`aoptions`
            FROM
                `mtjpt_modal_survey_answers`
            WHERE 
                `mtjpt_modal_survey_answers`.`survey_id` = {$surveyId}
                AND `mtjpt_modal_survey_answers`.`question_id` = {$questionId}
            "
        );
    }

    protected function getFilePathsFromCreateMode()
    {
        return $this->generateFilesPathsWrittenByCreateMode([
            $this->directory . '/' . $this->surveyIdMappingFilePrefix,
        ]);    
    }
}     