<?php 

namespace apo\migration\utilities\surveys;

class SurveyChapterFactory
{
    protected $surveyId;

    private $factoryNamespace = __NAMESPACE__ . '\\factories\\';

    private $defaultSurveyChapterModuleClassNamePrefix = 'SurveyChapterModules';

    /**
    * Creates a new instance of SurveyChapterFactory
    */
    public function __construct($surveyId)
    {
        $this->surveyId = $surveyId;
        $this->chapterFactory = $this->createChapterFactoryClass($surveyId);

        if ( !class_exists($this->chapterFactory) ) {
            throw new \Exception("Passed class {$this->chapterFactory} does not exists or does not match the given namespace of " . __NAMESPACE__);
        } 
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return (new $this->chapterFactory())->create();
    }

    /**
     * @param int $id
     * @return string factory class 
     */
    private function createChapterFactoryClass($id)
    {
        return $this->factoryNamespace . $this->defaultSurveyChapterModuleClassNamePrefix . $id;
    }

}