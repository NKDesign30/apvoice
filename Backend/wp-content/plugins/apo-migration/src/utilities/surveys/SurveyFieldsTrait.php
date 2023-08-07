<?php 

namespace apo\migration\utilities\surveys;

trait SurveyFieldsTrait 
{

    /**
     * All mapped survey ACF fields
     */
    protected $surveyFields = [];

    protected $surveyMetaModules = [
        'survey_meta_description' => 'field_5d1218f0786eb',
        'survey_meta_points' => 'field_5d121905786ec',
        'survey_meta_duration_group' => 'field_5d121797f2862',
        'survey_meta_duration_time' => 'field_5d12179ef2863',
        'survey_meta_duration_type' => 'field_5d1217aef2864',
        'survey_meta_expires_at' => 'field_5e58dba09b271',
    ];

    /**
     * Defines mapping of chapter groups from human readble => ACF
     */
    protected $surveyChapterKeys = [
        'survey_chapters_group' => 'field_5d1209b98dd6d',
        'survey_chapter_group' => 'field_5d120c62733b2',
    ];

    /**
     * Defines mapping of rating module from human readble => ACF
     */
    protected $surveyChapterRatingModule = [
        'survey_rating_layout_name' => 'rating',
        'survey_rating_question' => 'field_5ddd07101b244',
        'survey_rating_suheadline' => 'field_5ddd07401b249',
        'survey_rating_is_key_question' => 'field_5ddd07101b245',
        'survey_rating_items_group' => 'field_5ddd07501b24a',
        'survey_rating_items_item_headline' => 'field_5ddd07c71b24b',
        'survey_rating_items_item_options_group' => 'field_5ddd07101b246',
        'survey_rating_items_item_options_option_label' => 'field_5ddd07101b247',
        'survey_rating_items_item_options_option_tooltip' => 'field_5ddd07101b248',
    ];

   /**
     * Defines mapping of quiz module from human readble => ACF
     */
    protected $surveyChapterQuizModule = [
        'survey_quiz_layout_name' => 'quiz',
        'survey_quiz_question' => 'field_5d120e9786bd8',
        'survey_quiz_is_key_question' => 'field_5d2493be2382b',
        'survey_quiz_answer_options_group' => 'field_5d120ebe86bd9',
        'survey_quiz_answer_options_option_thats_right' => 'field_5d1215b11a3cf',
        'survey_quiz_answer_options_option_answer' => 'field_5d120ede86bda',
    ];

    /**
     * Defines mapping of single choice module from human readble => ACF
     */
    protected $surveyChapterSingleChoiceModule = [
        'survey_single_choice_layout_name' => 'choice',
        'survey_single_choice_question' => 'field_5d244ddb538a6',
        'survey_single_choice_is_key_question' => 'field_5d2493da2382c',
        'survey_single_choice_choices_group' => 'field_5d244ddb538a7',
        'survey_single_choice_choices_choice' => 'field_5d244dfe538aa',
        'survey_single_choice_choices_tooltip' => 'field_5d2459c7b8631',
    ];

    /**
     * Defines mapping of multi choice module from human readble => ACF
     */
    protected $surveyChapterMultiChoiceModule = [
        'survey_multi_choice_layout_name' => 'choice-multi',
        'survey_multi_choice_question' => 'field_5d246398710ed',
        'survey_multi_choice_is_key_question' => 'field_5d2493ea2382d',
        'survey_multi_choice_choices_group' => 'field_5d246398710ee',
        'survey_multi_choice_choices_choice' => 'field_5d246398710ef',
        'survey_multi_choice_choices_tooltip' => 'field_5d246398710f0',
    ];

    /**
     * Defines mapping of single line module from human readble => ACF
     */
    protected $surveyChapterAnswerSingleLineModule = [
        'survey_answer_single_line_layout_name' => 'answer-single-line',
        'survey_answer_single_line_question' => 'field_5d245eaf89642',
        'survey_answer_single_line_is_key_question' => 'field_5d2494032382e',
        'survey_answer_single_line_optional' => 'field_5d24947b8eead',
    ];

    /**
     * Defines mapping of multiline answer module from human readble => ACF
     */
    protected $surveyChapterAnswerMultiLineModule = [
        'survey_answer_multi_line_layout_name' => 'answer-multi-line',
        'survey_answer_multi_line_question' => 'field_5d2461c2446fe',
        'survey_answer_multi_line_is_key_question' => 'field_5d2494132382f',
        'survey_answer_multi_line_optional' => 'field_5d24949c8eeae',
    ];

    /**
     * Defines mapping of text paragraph module from human readble => ACF
     */
    protected $surveyChapterTextParagraphModule = [
        'survey_text_paragraph_layout_name' => 'text-paragraph',
        'survey_text_paragraph_copy' => 'field_5e429eedbabb2',
    ];

    public function generateSurveyFields()
    {
         $this->surveyFields = array_merge(
            $this->surveyMetaModules,
            $this->surveyChapterKeys,
            $this->surveyChapterRatingModule,
            $this->surveyChapterQuizModule,
            $this->surveyChapterSingleChoiceModule,
            $this->surveyChapterMultiChoiceModule,
            $this->surveyChapterAnswerSingleLineModule,
            $this->surveyChapterAnswerMultiLineModule,
            $this->surveyChapterTextParagraphModule,
         );

         return $this;
    }
}