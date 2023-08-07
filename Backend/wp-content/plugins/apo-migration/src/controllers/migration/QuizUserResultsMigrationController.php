<?php 
namespace apo\migration\controllers\migration;

use apo\trng\models\Lesson;
use apo\trng\models\Training;
use apo\migration\controllers\AbstractMigrationController;
use apo\migration\controllers\migration\UsersMigrationController;
use apo\migration\controllers\migration\TrainingsMigrationController;

class QuizUserResultsMigrationController extends AbstractMigrationController
{

    /**
     * Migration Status Identifier in table
     */
    const MIGRATION_STATUS_IDENTIFIER = 'training_quiz_results_migrated';

    /**
     * Define files and directories
     */
    const FILE_PREFIX = 'quiz_user_results_';
    const DIRECTORY = 'quiz_user_results';

    /**
     * Define files
     */
    protected $trainingIdMappingFilePrefix = TrainingsMigrationController::TRAINING_ID_MAPPING_FILE_PREFIX;
    protected $lessonUuidMappingFilePrefix = TrainingsMigrationController::LESSON_UUID_MAPPING_FILE_PREFIX;
    protected $userIdMappingFilePrefix = UsersMigrationController::USER_ID_MAPPING_FILE_PREFIX;

    /**
     * Defines subdirectories
     */
    protected $trainingsDirectory = TrainingsMigrationController::DIRECTORY;
    protected $usersDirectory = UsersMigrationController::DIRECTORY;

    /**
    * Creates a new instance of QuizUserResultsMigrationController
    */
    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAndWrite()
    {
        $results = [];

        $quizResults = $this->migrationDB->get_results(
            "SELECT 
                *
            FROM
                `mtjpt_aav_trainings`
            "
        );

        foreach ($this->countries as $key => $country) {
            $userIdMapping = $this->readFileFromSubdirectory($this->usersDirectory, $this->userIdMappingFilePrefix . $key)[0];
            $trainingIdMapping = $this->readFileFromSubdirectory($this->trainingsDirectory, $this->trainingIdMappingFilePrefix . $key)[0];

            $countrySpecifcQuizResults = array_values(array_filter($quizResults, function($quizResult) use ($userIdMapping, $trainingIdMapping) {
                return in_array($quizResult->uid, array_keys($userIdMapping)) && in_array($quizResult->qid, array_keys($trainingIdMapping));
            }));

            $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}", $countrySpecifcQuizResults);
            $results[$key] = sizeof($countrySpecifcQuizResults) . ' training quiz results was written in ' . $this->filePrefix . $key . '.json for ' . $country . '.';
        }

        return $this->printResults($results);
    }

    /**
     * Creates user quiz results
     */
    public function create()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->filePrefix,
            $this->usersDirectory . '/' . $this->userIdMappingFilePrefix,
            $this->trainingsDirectory . '/' . $this->trainingIdMappingFilePrefix,
            $this->trainingsDirectory . '/' . $this->lessonUuidMappingFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {

                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $trainingModel = new Training();
                $lessonModel = new Lesson();

                $userIdMapping = $this->readFileFromSubdirectory($this->usersDirectory, $this->userIdMappingFilePrefix . $countryKey)[0];
                $trainingIdMapping = $this->readFileFromSubdirectory($this->trainingsDirectory, $this->trainingIdMappingFilePrefix . $countryKey )[0];
                $lessonUuidMapping = $this->readFileFromSubdirectory($this->trainingsDirectory, $this->lessonUuidMappingFilePrefix . $countryKey )[0];

                $createdQuizResults = [];
                $lessonIds = [];

                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->filePrefix}{$countryKey}") as $quizResult) {

                    $userId = $userIdMapping[$quizResult['uid']];
                    $trainingId = $trainingIdMapping[$quizResult['qid']];
                    $isComplete = $this->isTimestampComplete($quizResult['complete']);
                    $createdAt = $isComplete ? $this->convertTimestampToDate($quizResult['complete']) : null;
                    $data = maybe_unserialize($quizResult['data']);

                    $lessons = array_map(function($d) use($quizResult, $lessonUuidMapping) {
                        return $lessonUuidMapping[$quizResult['qid']]['lessonGermanNameUuidMapping'][$d['id']];
                    }, $data);

                    $result = array_map(function($lesson) use($trainingId, $quizResult) {
                        return [
                            'training_id' => $trainingId,
                            'lesson_id' => $lesson,
                            'answers' => [],
                            'is_legacy' => true,
                            'notice' => 'Results was migrated from the de/at apovoice application. Answers was not tracked, because it was only possible to give correct answers.',
                            'legacy_data' => $quizResult['data'],
                        ];
                    }, $lessons);

                    // insert into wp_#_training_user_results
                    $createdQuizResults[] = $trainingModel->create([
                        'user_id' => $userId,
                        'training_id' => $trainingId,
                        'result' => maybe_serialize($result),
                        'is_complete' => $isComplete,
                    ]);
                    
                    // insert every completed lesson into wp_#_training_user_lessons
                    foreach ($data as $lesson) {
                        if($this->isTimestampComplete($lesson['complete'])) {
                            $lessonIds[] = $lessonModel->create([
                                'training_id' => $trainingId,
                                'user_id' => $userId,
                                'lesson_id' => $lessonUuidMapping[$quizResult['qid']]['lessonGermanNameUuidMapping'][$lesson['id']],
                            ]);
                        }
                    }
                    
                }

                $results[$countryKey] = "Added " . sizeof($createdQuizResults) . " Training-Quiz Results to {$country}\n";
                $results[$countryKey] .= "Added " . sizeof($lessonIds) . " Training-Quiz Lessons to {$country}\n";

                switch_to_blog(1);

            }
        }

        $this->setMigrationStatus();

        return $this->printResults($results);
    }

    /**
     * Checks if given param is a valid timestamp
     * @param int|string $timestamp
     * @return boolean
     */
    protected function isTimestampComplete($timestamp)
    {
        return $timestamp > 0;
    }

    /**
     * Converts timestamp to mysql created at date string
     * @param int|string $timestamp
     * @return datestring
     */
    protected function convertTimestampToDate($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }

}