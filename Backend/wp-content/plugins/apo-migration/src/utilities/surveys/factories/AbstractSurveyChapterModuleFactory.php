<?php 

namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\SurveyFieldsTrait;
use apo\migration\utilities\surveys\factories\SurveyChapterModuleInterface;

abstract class AbstractSurveyChapterModuleFactory implements SurveyChapterModuleInterface
{
  use SurveyFieldsTrait;

  /**
   * Amount of chapters
   */
  protected $chapters = [];

  /**
   * Survey modules clusterd by chapters
   */
  protected $chapterModules = [];

  /**
   * The current chapter
   */
  protected $currentChapter;

  /**
    * Creates a new instance of AbstractSurveyChapterModuleFactory
    */
    public function __construct()
    {
        $this->generateSurveyFields();
    }

  /**
   * Defines the whole amount of chapters for a survey
   * @param int $amount
   * @return this $this
   */
  protected function defineChapterAmount($amount)
  {
     for ($i=0; $i < $amount; $i++) { 
       $this->addChapter();
     }

     return $this;
  }

  /**
   * Add a new chapter by increasing incrementally
   * @return this $this
   */
  protected function addChapter()
  {
    $this->chapters[] = sizeof($this->chapters) + 1;

    return $this;
  }

  /**
   * Add a module to a given chapter
   * @param string $type
   * @param mixed $values
   * @param int $chapter
   * @return this $this
   */
  protected function addModule($type, $values, $chapter = null)
  {
    $currentChapter = $chapter ?? $this->currentChapter;

    $module = $this->createModule(['type' => $type, 'values' => $values]);

    $this->chapterModules[$currentChapter][] = $module;

    return $this;
  }

  /**
   * Set the current chapter
   * @param int $chapter
   * @return this $this
   */
  protected function setChapter($chapter)
  {
    if (!in_array($chapter, $this->chapters)) {
      throw new \Exception('Chapter does not exists');
    }
    $this->currentChapter = $chapter;

    return $this;
  }

   /**
   * Return generated collected chapters and modules
   * @return array
   */
  protected function getGeneratedChapters()
  {
    foreach ($this->chapterModules as $chapter => $modules) {
      $surveyChapters[$chapter] = [$this->surveyFields['survey_chapter_group'] =>
          $modules,  
        ];
    }

    return $surveyChapters;
  }

  /**
   * Creates a survey module
   * @param array $module
   * @return array 
   */
  protected function createModule($module)
  {
  
    $methodName =  "create{$this->toPascalCase($module['type'])}Module";

    if( method_exists($this, $methodName) ) {
      return $this->$methodName($module);
    }

    throw new \Exception('Method does not exists');
  }

  /**
   * Creates a text-paragraph module
   * @param array $module
   * @return array
   */
  protected function createTextParagraphModule($module)
  {
    return [
      $this->surveyFields['survey_text_paragraph_copy'] => $module['values'],
      'acf_fc_layout' => $this->surveyFields['survey_text_paragraph_layout_name'],
    ];
  }

  /**
   * Creates a rating module
   * @param array $module
   * @return array
   */
  protected function createRatingModule($module)
  {
    return [
      $this->surveyFields['survey_rating_question'] => $module['values']['question'],
      $this->surveyFields['survey_rating_suheadline'] => $module['values']['subheadline'],
      $this->surveyFields['survey_rating_items_group'] => array_map( function ($option) {
        return [
            $this->surveyFields['survey_rating_items_item_headline'] => $option['headline'],
            $this->surveyFields['survey_rating_items_item_options_group'] => array_map( function ($item) {
                return [
                    $this->surveyFields['survey_rating_items_item_options_option_label'] => $item,
                    $this->surveyFields['survey_rating_items_item_options_option_tooltip'] => $item,
                ];
            }, $option['items']),
        ];
      }, $module['values']['options']),
      'acf_fc_layout' => $this->surveyFields['survey_rating_layout_name'],
    ];
  }

  /**
   * Creates a single choice module
   * @param array $module
   * @return array
   */
  protected function createSingleChoiceModule($module)
  {
    return [
      $this->surveyFields['survey_single_choice_question'] => $module['values']['question'],
      $this->surveyFields['survey_single_choice_choices_group'] => array_map( function($value) {
        return [
            $this->surveyFields['survey_single_choice_choices_choice'] => strtolower($value),
            $this->surveyFields['survey_single_choice_choices_tooltip'] => $value,
        ];
      }, $module['values']['options']),
      'acf_fc_layout' => $this->surveyFields['survey_single_choice_layout_name'],
    ];
  }

  /**
   * Creates a single choice module
   * @param array $module
   * @return array
   */
  protected function createMultiChoiceModule($module)
  {
    return [
      $this->surveyFields['survey_multi_choice_question'] => $module['values']['question'],
      $this->surveyFields['survey_multi_choice_choices_group'] => array_map( function($value) {
        return [
            $this->surveyFields['survey_multi_choice_choices_choice'] => strtolower($value),
            $this->surveyFields['survey_multi_choice_choices_tooltip'] => $value,
        ];
      }, $module['values']['options']),
      'acf_fc_layout' => $this->surveyFields['survey_multi_choice_layout_name'],
    ];
  }

  /**
   * Creates a answer single line module
   * @param array $module
   * @return array
   */
  protected function createAnswerSingleLineModule($module)
  {
    return [
      $this->surveyFields['survey_answer_single_line_question'] => $module['values']['question'],
      'acf_fc_layout' => $this->surveyFields['survey_answer_single_line_layout_name'],
    ];
  }

  /**
   * Converts a string to PascalCase 
   * @param string $str
   * @return string
   */
  public function toPascalCase($str)
  {
      $str = preg_replace('/[^a-z0-9]+/i', ' ', $str);
      $str = trim($str);
      $str = ucwords($str);
      $str = str_replace(" ", "", $str);
      $str = lcfirst($str);

      return ucfirst($str);
  }

  

}