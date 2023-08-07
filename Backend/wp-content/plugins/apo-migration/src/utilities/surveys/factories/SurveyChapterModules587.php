<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules587 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules587
    */
    public function __construct()
    {
        parent::__construct();

        $this->defineChapterAmount(13);
        $this->generateModules();
    }

    public function create() 
    {
        return $this->getGeneratedChapters();
    }

    public function generateModules()
    {
        $this->addModule('text-paragraph', 
            'Mit Online-Schulungen ist es wie mit Apps auf dem Handy – das Angebot ist groß und wird immer größer. Bitte nimm Dir kurz Zeit, uns zu sagen, welches Deine Favoriten sind und warum – damit wir Dir in Zukunft noch bessere eTrainings anbieten können.', 
            1)
            ->addModule('rating', [
                'question' => 'PTA Channel',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 2)
            ->addModule('rating', [
                'question' => 'Apothekia',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 3)
            ->addModule('rating', [
                'question' => 'Marpinion',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 4)
            ->addModule('rating', [
                'question' => 'PTA Heute',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 5)
            ->addModule('rating', [
                'question' => 'GEHE',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 6)
            ->addModule('rating', [
                'question' => 'apovoice',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 7)
            ->addModule('rating', [
                'question' => 'Thomae Akademie',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 8)
            ->addModule('rating', [
                'question' => 'Ratiopharm',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 9)
            ->addModule('rating', [
                'question' => 'Almased',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 10)
            ->addModule('rating', [
                'question' => 'Schwabe',
                'options' => [
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Internaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 11)
            ->addModule('rating', [
                'question' => 'Bionorica',
                'options' => [
                    [
                        'headline' => 'Bionorica
                        Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an?(1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 12)
            ->addModule('rating', [
                'question' => 'Bionorica',
                'options' => [
                    [
                        'headline' => 'Wie hat dir dieses online Training inhaltlich gefallen? (1= sehr gut bis 5= nicht gut, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wieviel Spaß (durch verschiedene Interaktionen) hattest Du bei diesem online Training? (1= sehr gut bis 5= gar nicht, nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie sehr hilft dir das erlernte Wissen von diesem online Training bei deiner täglichen Arbeit? (1= sehr gut bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie lange wendest du das erlernte Wissen aus diesem online Training in deinen Beratungsgesprächen an? (1= 1-2 Wochen bis 5= über 12 Wochen, 6= nie online Trainings gemacht)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                    [
                        'headline' => 'Wie hoch ist die Wahrscheinlichkeit, dass du dieses online Training einer Kollegin/einem Kollegen weiterempfehlen würdest? (1= sehr hoch bis 5= gar nicht, 6= nicht teilgenommen)',
                        'items' => [1, 2, 3, 4, 5, 6],
                    ],
                ],
            ], 13);

        return $this;
    }

}