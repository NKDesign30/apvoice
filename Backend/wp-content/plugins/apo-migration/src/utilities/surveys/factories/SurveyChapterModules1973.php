<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules1973 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules1973
    */
    public function __construct()
    {
        parent::__construct();

        $this->defineChapterAmount(10);
        $this->generateModules();
    }

    public function create() 
    {
        return $this->getGeneratedChapters();
    }

    public function generateModules()
    {
        $this->addModule('text-paragraph', 
                'Vielen Dank, dass Du das eTraining zu Femibion® erfolgreich absolviert hast. Auf den folgenden Seiten möchten wir gern etwas zu Deinen Erfahrungen mit diesem Training wissen.', 
            1)
            ->addModule('rating', [
                'question' => 'Wie hat Dir das Training insgesamt gefallen? (1=gar nicht gut bis 5= sehr gut)',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5],
                    ],
                ],
            ], 2)
            ->addModule('single-choice', [
                'question' => 'Hast Du durch die Schulung zusätzliche Erkenntnisse für Deine tägliche Arbeit in der Apotheke gewonnen?',
                'options' => ['ja', 'nein'],
            ], 3)
            ->addModule('text-paragraph', 
                'Wenn Du die vorherige Frage „Hast Du durch die Schulung zusätzliche Erkenntnisse für Deine tägliche Arbeit in der Apotheke gewonnen?“ mit „Ja“ beantwortet hast, dann beantworte bitte diese Fragen. Ansonsten klicke auf „Weiter“.', 
            4)
            ->addModule('single-choice', [
                'question' => 'Ja, ich weiß nun welchen meiner Kunden ich das Produkt empfehlen kann ',
                'options' => ['ja', 'nein'],
            ], 4) 
            ->addModule('single-choice', [
                'question' => 'Ja, ich verstehe die Produktvorteile ',
                'options' => ['ja', 'nein'],
            ], 4) 
            ->addModule('single-choice', [
                'question' => 'Ja, ich kann die Produkte gegeneinander abgrenzen',
                'options' => ['ja', 'nein'],
            ], 4)
            ->addModule('answer-single-line', [
                'question' => 'Ja, anderer Grund'
            ], 4)
            ->addModule('text-paragraph', 
                'Wenn Du die vorherige Frage „Hast Du durch die Schulung zusätzliche Erkenntnisse für Deine tägliche Arbeit in der Apotheke gewonnen?“ mit „Nein“ beantwortet hast, beantworte bitte diese Fragen. Ansonsten klicke auf „Weiter“.', 
            5)
            ->addModule('single-choice', [
                'question' => 'Nein, Ich wußte bereits alles',
                'options' => ['ja', 'nein'],
            ], 5) 
            ->addModule('single-choice', [
                'question' => 'Nein, ich weiterhin liebe7r ein anderes Produkt empfehle',
                'options' => ['ja', 'nein'],
            ], 5) 
            ->addModule('single-choice', [
                'question' => 'Nein, weil ich das Produkt noch nicht selbst ausprobiert habe.',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('answer-single-line', [
                'question' => 'Nein, anderer Grund'
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Hast Du Deinen Kunden bereits vorher das geschulte Produkt empfohlen?',
                'options' => ['ja', 'nein'],
            ], 6)
            ->addModule('single-choice', [
                'question' => 'Wenn ja, ist es das Produkt, dass Du Deinen Kunden am häufigsten empfiehlst?',
                'options' => ['ja', 'nein'],
            ], 6)
            ->addModule('rating', [
                'question' => 'Wenn nein, wie hoch ist die Wahrscheinlichkeit, dass Du es zukünftig empfiehlst? (1=sehr wahrscheinlich/ 5=sehr unwahrscheinlich)',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5],
                    ],
                ],
            ], 6)
            ->addModule('rating', [
                'question' => 'Wie empfindest Du das fachliche Niveau des eTrainings? (1=gar nicht gut bis 5=sehr gut)',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5],
                    ],
                ],
            ], 7)
            ->addModule('rating', [
                'question' => 'Wie empfindest Du die Aufbereitung des eTrainings? (1=gar nicht gut bis 5=sehr gut)',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5],
                    ],
                ],
            ], 8)
            ->addModule('rating', [
                'question' => 'Wie wichtig ist Dir das Zertifikat nach Absolvieren des eTrainings? (1=gar nicht gut bis 5=sehr gut)',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5],
                    ],
                ],
            ], 9)
            ->addModule('answer-single-line', [
                'question' => 'Hast Du noch weiteres Feedback zu den eTrainings für uns? (Vorschläge, Anregungen, Lob)'
            ], 10);

        return $this;
    }

}