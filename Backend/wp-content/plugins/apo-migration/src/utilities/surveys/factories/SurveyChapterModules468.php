<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules468 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules468
    */
    public function __construct()
    {
        parent::__construct();

        $this->defineChapterAmount(6);
        $this->generateModules();
    }

    public function create() 
    {
        return $this->getGeneratedChapters();
    }

    public function generateModules()
    {
        $this->addModule('text-paragraph', 
            'Wir haben ein paar Fragen an Dich zum Thema Produktplatzierungen in Deiner Apotheke.', 
            1)
            ->addModule('single-choice', [
                'question' => 'Wärst du grundsätzlich bereit die Sichtwahl/Freiwahl durch einen Außendienstmitarbeiter eines Arzneimittelherstellers umbauen zu lassen?',
                'options' => ['ja', 'eher ja', 'vielleicht', 'eher nein', 'nein'],
            ], 2)
            ->addModule('answer-single-line', [
                'question' => 'Kannst du kurz deine Auswahl begründen, bzw. was könnte deine Bereitschaft dazu erhöhen?'
            ], 2)
            ->addModule('single-choice', [
                'question' => 'Inwiefern könnten Studien, bspw. Umsatzanalysen deine Bereitschaft erhöhen?',
                'options' => ['stark', 'etwas', 'gar nich'],
            ], 3)
            ->addModule('answer-single-line', [
                'question' => 'Nach welchen Kriterien sind bei dir Vitamin D Präparate in der Freiwahl platziert?'
            ], 4)
            ->addModule('answer-single-line', [
                'question' => 'Nach welchen Kriterien sind bei dir Vitamin D Präparate in der Sichtwahl platziert?'
            ], 5)
            ->addModule('answer-single-line', [
                'question' => 'Was wünschst du dir seitens eines Herstellers, um sein Vitamin D Produkt breiter zu platzieren?'
            ], 6);

        return $this;
    }

}