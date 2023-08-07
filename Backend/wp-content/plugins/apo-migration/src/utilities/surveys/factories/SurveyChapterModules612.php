<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules612 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules612
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
                'Die Schwangerschaft ist für Frauen ein bedeutender Abschnitt in ihrem Leben. Die Apotheke und ihre Mitarbeiter sind in diesem Lebensabschnitt wichtige Berater in den einzelnen Phasen der Schwangerschaft. Wir würden gern Deine Einschätzung zu ein paar Themen haben und bitten Dich, die folgenden Fragen zu beantworten.', 
            1)
            ->addModule('text-paragraph', 
                'Denke an Situationen rund um die Beratung zu Schwangerschaftsvitaminen.', 
            2)
            ->addModule('rating', [
                'question' => 'Was trifft häufiger zu: (1) Kundinnen möchten allgemein zu Schwangerschaftsvitaminen beraten werden (2) Kundinnen haben konkrete Fragen zu Produkten',
                'options' => [
                    [
                        'items' => [1, 2],
                    ],
                ],
            ], 2)
            ->addModule('rating', [
                'question' => 'Wie viele von 10 Kundinnen, möchten von dir allgemein zu Schwangerschaftsvitaminen beraten werden?',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 3)
            ->addModule('rating', [
                'question' => 'Wie viele von 10 Kundinnen haben konkrete Fragen zu den Produkten?',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 3)
            ->addModule('rating', [
                'question' => 'Wie viele von 10 Kundinnen wollen keine Beratung?',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 3)
            ->addModule('multi-choice', [
                'question' => 'Falls die Kundinnen Rückfragen haben, zu welchen Themengebieten? (Mehrfachauswahl)',
                'options' => [
                    'Einnahme',
                    'Inhaltsstoffe',
                    'Zusammensetzung',
                    'Verträglichkeit',
                    'Rückversicherung, ob das Produkt eine gute Wahl ist',
                    'Deine persönliche Meinung zum Produkt',
                    'Unterschiede zwischen Produkten von verschiedenen Herstellern',
                    'Die Wahl des passenden Produktes zum jeweiligen Schwangerschaftsstatus (bspw.: Phase 0, 1, 2, 3)',
                ],
            ], 4)
            ->addModule('answer-single-line', [
                'question' => 'Haben die Kundinnen Rückfragen zu sonstigen Themengebieten? '
            ], 4)
            ->addModule('rating', [
                'question' => 'Wie sicher sind die Kundinnen, deiner Einschätzung nach, bei der Wahl des richtigen Schwangerschaftsproduktes auf einer Skala von 1-10 (1 sehr unsicher bis 10 sehr sicher)',
                'options' => [
                    [
                        'headline' => 'Insgesamt',
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                    [
                        'headline' => 'In der Baby Planungsphase',
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                    [
                        'headline' => 'In der Frühschwangerschaft',
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                    [
                        'headline' => 'In der Spätsschwangerschaft',
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 5)
            ->addModule('rating', [
                'question' => 'Wie sicher sind die Kundinnen, deiner Einschätzung nach, beim Kauf eines Produktes der folgenden Marken auf einer Skala von 1-10 (1 sehr unsicher bis 10 sehr sicher)',
                'options' => [
                    [
                        'headline' => 'In der Stillzeit',
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                    [
                        'headline' => 'Folio',
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                    [
                        'headline' => 'Femibion',
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                    [
                        'headline' => 'Elevit',
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 6);

        return $this;
    }

}