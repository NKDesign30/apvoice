<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules411 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules411
    */
    public function __construct()
    {
        parent::__construct();

        $this->defineChapterAmount(1);
        $this->generateModules();
    }

    public function create() 
    {
        return $this->getGeneratedChapters();
    }

    public function generateModules()
    {
        $this->setChapter(1)
            ->addModule('rating', [
                'question' => 'Wir haben ein paar allgemeine Fragen an Dich zum neuen Look von Apovoice. Wie bewertest Du die folgenden Kriterien?',
                'subheadline' => 'Bitte bewerte von 1=gar nicht bis 5=sehr gut',
                'options' => [
                    [
                        'headline' => 'Wie gut gefällt Dir das neue Apovoice Logo?',
                        'items' => [1, 2, 3, 4, 5],
                    ],
                    [
                        'headline' => 'Wie gut gefällt Dir die neue Farbgebung von Apovoice?',
                        'items' => [1, 2, 3, 4, 5],
                    ],
                    [
                        'headline' => 'Wie gut gefällt Dir Dein neues Profil?',
                        'items' => [1, 2, 3, 4, 5],
                    ],
                    [
                        'headline' => 'Wie benutzerfreundlich findest Du die neue Apovoice Website?',
                        'items' => [1, 2, 3, 4, 5],
                    ],
                ]
            ])
            ->addModule('answer-single-line', [
                'question' => 'Hast Du noch Verbesserungsvorschläge bezüglich des neuen Looks?'
            ]);

        return $this;
    }
}