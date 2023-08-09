<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules454 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules454
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
            'Wir haben ein paar allgemeine Fragen an Dich zu Deinen Erfahrungen in der täglichen Kundenberatung mit topischen Schmerzsalben.', 
            1)
            ->addModule('rating', [
                'question' => 'Wie viele von 10 Kunden kommen mit einem klaren Produktwunsch zu dir in die Apotheke?',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 2)
            ->addModule('rating', [
                'question' => 'Wie viele von 10 Kunden kommen ohne einen Produktwunsch zu dir und wünschen eine Beratung für das richtige Produkt?',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 3)
            ->addModule('rating', [
                'question' => 'Wie viele von 10 Kunden kommen mit einer Produktempfehlung vom Arzt, lassen sich aber von deiner Empfehlung für ein anderes Produkt überzeugen?',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 4)
            ->addModule('rating', [
                'question' => 'Wie viele von 10 Kunden kommen mit einer bestimmten Produktempfehlung vom Arzt und kaufen dann auch dieses Produkt?',
                'options' => [
                    [
                        'items' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ],
                ],
            ], 5)
            ->addModule('answer-single-line', [
                'question' => 'Hast du ein Produkt, das du im Bereich topischer Schmerzsalben am häufigsten empfiehlst? Wenn ja, welches und warum?',
            ], 6);

        return $this;
    }

}