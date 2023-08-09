<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules1191 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules1191
    */
    public function __construct()
    {
        parent::__construct();

        $this->defineChapterAmount(14);
        $this->generateModules();
    }

    public function create() 
    {
        return $this->getGeneratedChapters();
    }

    public function generateModules()
    {
        $this->addModule('text-paragraph', 
            'Willkommen bei apovoice! Vielen Dank, dass Du Dir die Zeit nimmst, an unserer Umfrage teilzunehmen.', 
        1)
        ->addModule('single-choice', [
            'question' => 'Präsenzveranstaltungen',
            'options' => ['Ja', 'Nein'],
        ], 2)
        ->addModule('single-choice', [
            'question' => 'Online-Trainings',
            'options' => ['Ja', 'Nein'],
        ], 2)
        ->addModule('single-choice', [
            'question' => 'Podcasts',
            'options' => ['Ja', 'Nein'],
        ], 2)
        ->addModule('rating', [
            'question' => 'Wie gefallen Dir die Angebote der folgenden Portale? (1=schlecht bis 5=sehr gut)',
            'options' => [
                [
                    'headline' => 'PTA Heute',
                    'items' => [1, 2, 3, 4, 5],
                ],
                [
                    'headline' => 'Apotekia',
                    'items' => [1, 2, 3, 4, 5],
                ],
                [
                    'headline' => 'apovoice',
                    'items' => [1, 2, 3, 4, 5],
                ],
                [
                    'headline' => 'Marpinion',
                    'items' => [1, 2, 3, 4, 5],
                ],
                [
                    'headline' => 'PTA Channel',
                    'items' => [1, 2, 3, 4, 5],
                ],
            ],
        ], 3)
        ->addModule('answer-single-line', [
            'question' => 'Was findest Du an apovoice besonders?',
        ], 4)
        ->addModule('answer-single-line', [
            'question' => 'Was kann man an apovoice noch optimieren?',
        ], 5)
        ->addModule('answer-single-line', [
            'question' => 'Was wünscht du Dir an Unterstützung von der pharmazeutischen Industrie für deine tägliche Arbeit in der Apotheke?',
        ], 6)
        ->addModule('text-paragraph', 
            'Wir haben hier schon einige mögliche Themen aufgeschrieben, bitte sag uns für jedes einzelne, ob Du hier Unterstützung wünschst und wenn ja, in welcher Form.', 
            7)
        ->addModule('rating', [
            'question' => 'Wie wichtig sind Dir Infos zur Indikation? (1=unwichtig bis 5=sehr wichtig)',
            'options' => [
                [
                    'headline' => null,
                    'items' => [1, 2, 3, 4, 5],
                ],
            ],
        ], 8)
        ->addModule('answer-single-line', [
            'question' => 'Magst Du uns bitte Beispiele nennen? (Indikation)',
        ], 8)
        ->addModule('rating', [
            'question' => 'Wie wichtig sind Dir Infos zu den Produkten? (1=unwichtig bis 5=sehr wichtig)',
            'options' => [
                [
                    'headline' => null,
                    'items' => [1, 2, 3, 4, 5],
                ],
            ],
        ], 9)
        ->addModule('answer-single-line', [
            'question' => 'Magst Du uns bitte Beispiele nennen? (Produkt)',
        ], 9)
        ->addModule('rating', [
            'question' => 'Wie wichtig sind Dir Infos zur Beratung? (1=unwichtig bis 5=sehr wichtig)',
            'options' => [
                [
                    'headline' => null,
                    'items' => [1, 2, 3, 4, 5],
                ],
            ],
        ], 10)
        ->addModule('answer-single-line', [
            'question' => 'Magst Du uns bitte Beispiele nennen? (Beratung)',
        ], 10)
        ->addModule('rating', [
            'question' => 'Wie wichtig ist Dir schneller Zugriff auf Informationen? (1=unwichtig bis 5=sehr wichtig)',
            'options' => [
                [
                    'headline' => null,
                    'items' => [1, 2, 3, 4, 5],
                ],
            ],
        ], 11)
        ->addModule('answer-single-line', [
            'question' => 'Magst Du uns bitte Beispiele nennen? (Information)',
        ], 11)
        ->addModule('rating', [
            'question' => 'Wie wichtig ist Dir schneller Zugriff auf Informationen? (1=unwichtig bis 5=sehr wichtig)',
            'options' => [
                [
                    'headline' => null,
                    'items' => [1, 2, 3, 4, 5],
                ],
            ],
        ], 12)
        ->addModule('answer-single-line', [
            'question' => 'Magst Du uns bitte Beispiele nennen? (Information)',
        ], 12)
        ->addModule('rating', [
            'question' => 'Wie wichtig ist Dir Unterstützung durch mehr Werbung beim Verbraucher (TV, Zeitschriften etc.)? (1=unwichtig bis 5=sehr wichtig)',
            'options' => [
                [
                    'headline' => null,
                    'items' => [1, 2, 3, 4, 5],
                ],
            ],
        ], 13)
        ->addModule('answer-single-line', [
            'question' => 'Magst Du uns bitte Beispiele nennen? (Werbung)',
        ], 13)
        ->addModule('rating', [
            'question' => 'Wie wichtig ist Dir eine intensive Betreuung durch deinen Außendienst? (1=unwichtig bis 5=sehr wichtig)',
            'options' => [
                [
                    'headline' => null,
                    'items' => [1, 2, 3, 4, 5],
                ],
            ],
        ], 14)
        ->addModule('answer-single-line', [
            'question' => 'Magst Du uns bitte Beispiele nennen? (Aussendienst)',
        ], 14);

        return $this;
    }
}