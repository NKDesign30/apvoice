<?php 

namespace apo\migration\utilities;

trait LessonsTrait {

    /**
     * Defines mapping from ACF => human readable
     */
    protected $lessonFieldsMapper = [
        '_lessons' => 'lessons_group',
        '_lessons_0_lesson' => 'lesson_group',
        '_lessons_0_lesson_lesson_id' => 'lesson_uuid',
        '_lessons_0_lesson_meta_infos' => 'lesson_meta_infos_group',
        '_lessons_0_lesson_meta_infos_title' => 'lesson_meta_title',
        '_lessons_0_lesson_meta_infos_sub_title' => 'lesson_meta_sub_title',
        '_lessons_0_lesson_meta_infos_description' => 'lesson_meta_description',
        '_lessons_0_lesson_meta_infos_duration' => 'lesson_meta_duration_group',
        '_lessons_0_lesson_meta_infos_duration_time' => 'lesson_meta_duration_time',
        '_lessons_0_lesson_meta_infos_duration_type' => 'lesson_meta_duration_type',
        '_lessons_0_lesson_sections' => 'lesson_section_group',
        '_lessons_0_lesson_sections_0_title' => 'lesson_section_title',
        '_lessons_0_lesson_quiz' => 'lesson_quiz_group',
        '_lessons_0_lesson_quiz_headline' => 'lesson_quiz_headline',
        '_lessons_0_lesson_quiz_subheadline' => 'lesson_quiz_subheadline',
        '_lessons_0_lesson_quiz_chapters' => 'lesson_quiz_chapters_group',
        '_lessons_0_lesson_quiz_chapters_0_chapter_id' => 'lesson_quiz_chapter_uuid',
        '_lessons_0_lesson_quiz_chapters_0_question' => 'lesson_quiz_chapter_question',
        '_lessons_0_lesson_quiz_chapters_0_choices' => 'lesson_quiz_chapter_choices_group',
        '_lessons_0_lesson_quiz_chapters_0_choices_0_choice_id' => 'lesson_quiz_chapter_choice_uuid',
        '_lessons_0_lesson_quiz_chapters_0_choices_0_value' => 'lesson_quiz_chapter_choice_value',
        '_lessons_0_lesson_quiz_chapters_0_choices_0_is_true' => 'lesson_quiz_chapter_choice_is_true',
    ];

    /**
     * Define defaul lesson sections for germany
     */
    protected $defaultGermanLessonKeys = [
        'indication', 
        'produkt', 
        'beratung'
    ];

    /**
     * Defines abstract key mapping to extract data for every section
     */
    protected $rawLessonKeyMapping = [
        'training_sections_###IDENTIFIER###_name' => 'title',
        'training_sections_###IDENTIFIER###_data_preview_subtext' => 'sub_title',
        'training_sections_###IDENTIFIER###_data_preview_text' => 'description',
        'training_sections_###IDENTIFIER###_data_preview_time' => 'time',
        'training_sections_###IDENTIFIER###_data_training_tabs_###TAB_NUMBER###_tab_name' => 'section_titles',
        'training_sections_###IDENTIFIER###_data_training_tabs_###TAB_NUMBER###_layout_0_before_quiz_text' => 'quiz_titles',
        'training_sections_###IDENTIFIER###_data_training_tabs_###TAB_NUMBER###_layout_0_quiz_questions_###QUIZ_INDEX###_question' => 'quiz_question',
        'training_sections_###IDENTIFIER###_data_training_tabs_###TAB_NUMBER###_layout_0_quiz_questions_###QUIZ_INDEX###_answers_###ANSWER_INDEX###_text' => 'quiz_answers_text',
        'training_sections_###IDENTIFIER###_data_training_tabs_###TAB_NUMBER###_layout_0_quiz_questions_###QUIZ_INDEX###_answers_###ANSWER_INDEX###_is_valid' => 'quiz_answers_validations',
    ];

    /**
     * Will be filled with propper key value mapping for lessons
     */
    protected $lessonKeys = [];

    /**
     * Build for each german section an lesson key value pair
     */
    protected function buildLessonKeys()
    {
        foreach ($this->defaultGermanLessonKeys as $germanKey) {
            foreach ($this->rawLessonKeyMapping as $rawKey => $simplifiedKey) {
                    $this->lessonKeys[$germanKey][ str_replace('###IDENTIFIER###', $germanKey, $rawKey) ] = $simplifiedKey;
            }
        }
        return $this;
    }

    /**
     * Extract neccessary keys from post meta data
     * @param array $postMeta
     * @return array
     */
    protected function extractLessonDataFromPostMeta( $postMeta )
    {
        $extractedLessonData = array_filter($postMeta, function ( $m ) {
            return preg_match('/^(training_tabs_layout|training_sections_(indication|produkt|beratung)_(name|data_preview_\w+|\w+tab_name|\w+(quiz_questions_|quiz_text)?\w+)$)/', $m);
        }, ARRAY_FILTER_USE_KEY);
        return array_map('strip_tags', $extractedLessonData);
    }

    /**
     * Group extracted data into named sections
     * @param array $extractedLessonData
     * @return array
     */
    protected function groupLessonData( $extractedLessonData )
    {
        $groupedLessonData = [];
        foreach ($extractedLessonData as $key => $value) {
            preg_match('/_(?<identifier>(indication|produkt|beratung))_/', $key, $match);
                
            if(strpos($key, $match['identifier'])) {
                if((bool) preg_match('/tabs_(?<tabIndex>\d+)_tab/', $key))  {
                    
                    // skip german sections which contains quiz.
                    // these sections are used separately in the international app
                    if( !mb_stripos($value, 'Quiz') ) {
                        $groupedLessonData[$match['identifier']]['section_titles'][] = $value;
                    }

                } else if ((bool) preg_match('/tabs_(?<tabIndex>\d+)_\w+_quiz_(?<quizKey>text$|questions)(_(?<chapterIndex>\d+)_(?<fieldKey>question|answers)(_(?<answerIndex>\d+)_(?<answerKey>text|is_valid))?)?/', $key, $quizMatch)) {
                    if( (bool) preg_match('/before|after/i', $key) === false ) {

                        // extract headlines
                        if($quizMatch['quizKey'] === 'text') {
                            $headlines = explode(':', $value);
                            $subheadline = explode(PHP_EOL, trim($headlines[1]))[1];
                            $groupedLessonData[$match['identifier']]['quiz']['headline'] = $headlines[0];
                            $groupedLessonData[$match['identifier']]['quiz']['subheadline'] = $subheadline;
                        }
                        // extract quiz question 
                        else if ($quizMatch['quizKey'] === 'questions' && $quizMatch['fieldKey'] === 'question') {
                            $groupedLessonData[$match['identifier']]['quiz'][$quizMatch['chapterIndex']]['question'] = $value;
                        } 
                        // extract question answer options 
                        else if ($quizMatch['quizKey'] === 'questions' && $quizMatch['fieldKey'] === 'answers' && $quizMatch['answerKey']) {
                            $groupedLessonData[$match['identifier']]['quiz'][$quizMatch['chapterIndex']]['answers'][$quizMatch['answerIndex']][$quizMatch['answerKey']] = $value;
                        }
                                    
                    }
                } else {
                    $groupedLessonData[$match['identifier']][ $this->lessonKeys[$match['identifier']][$key] ] = $value;
                }
            }
        }

        return $groupedLessonData;
    }

    /**
     * Generates propper data structure to insert lesson data into AdvancedCustomFields
     * @param array $groupedLessonData
     * @return array
     */
    protected function generateACFLessonGroup( $groupedLessonData )
    {
        $lessonsGroupACFValues = [];
        $lessonGermanNameUuidMapping = [];
        foreach ($groupedLessonData as $key => $lesson) {
            $time = explode(' ', $lesson['time']);
            $uuid = uniqid();

            // TODO: check if a chapterUuid and choiceUuid mapping is required
            // $chapterUuid = uniqid();
            // $choiceUuid = uniqid();

            $lessonGermanNameUuidMapping[$key] = $uuid;

            // map section names
            $sectionNames = [];
            if(array_key_exists('section_titles', $lesson)) {
                $sectionNames = array_map(function($sectionName) {
                    return [
                        $this->fields['lesson_section_title'] => $sectionName,
                    ];
                }, $lesson['section_titles']);
            }
            
            // create & map quiz data
            $quizHeadline = '';
            $quizSubheadline = '';
            $quizChapters = [];
            if(array_key_exists('quiz', $lesson)) {
                $quiz = $lesson['quiz'];
                $quizHeadline = array_pluck($quiz, 'headline');
                $quizSubheadline = array_pluck($quiz, 'subheadline');
                $quizChapters = array_map(function($chapter) {
                    return [
                        $this->fields['lesson_quiz_chapter_uuid'] => uniqid(),
                            $this->fields['lesson_quiz_chapter_question'] => $chapter['question'],
                            $this->fields['lesson_quiz_chapter_choices_group'] => array_map(function($answer) {
                                return [
                                    $this->fields['lesson_quiz_chapter_choice_uuid'] => uniqid(),
                                    $this->fields['lesson_quiz_chapter_choice_value'] => $answer['text'],
                                    $this->fields['lesson_quiz_chapter_choice_is_true'] => (int) $answer['is_valid'],
                                ];
                            }, $chapter['answers']),
                    ];
                }, $quiz);
            }
           
            $lessonsGroupACFValues[] = [$this->fields['lesson_group'] => 
                [
                    $this->fields['lesson_meta_infos_group'] => [
                        $this->fields['lesson_meta_title'] => $lesson['title'],
                        $this->fields['lesson_meta_sub_title'] => $lesson['sub_title'],
                        $this->fields['lesson_meta_description'] => $lesson['description'],
                        $this->fields['lesson_meta_duration_group'] => [
                            $this->fields['lesson_meta_duration_time'] => $time[0],
                            $this->fields['lesson_meta_duration_type'] => 'min',
                        ],
                    ],
                    $this->fields['lesson_quiz_group'] => [
                        $this->fields['lesson_quiz_headline'] => $quizHeadline,
                        $this->fields['lesson_quiz_subheadline'] => $quizSubheadline,
                        $this->fields['lesson_quiz_chapters_group'] => $quizChapters,
                    ],
                    $this->fields['lesson_uuid'] => $uuid,
                    $this->fields['lesson_section_group'] => $sectionNames,
                ],
            ];
        }

        return [
            'selector' => $this->fields['lessons_group'],
            'value' => $lessonsGroupACFValues,
            'lessonGermanNameUuidMapping' => $lessonGermanNameUuidMapping,
        ];

    }

    /**
     * Returns prepared lesson data
     * @param array $postMeta
     * @return array
     */
    protected function getLessonData( $postMeta )
    {
         return $this->generateACFLessonGroup(
            $this->groupLessonData(
                $this->extractLessonDataFromPostMeta($postMeta)
            )
        );
    }

}