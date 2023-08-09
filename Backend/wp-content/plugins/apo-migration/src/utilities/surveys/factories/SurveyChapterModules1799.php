<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules1799 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules1799
    */
    public function __construct()
    {
        parent::__construct();

        $this->defineChapterAmount(12);
        $this->generateModules();
    }

    public function create() 
    {
        return $this->getGeneratedChapters();
    }

    public function generateModules()
    {
        $this->addModule('text-paragraph', 
                'Vielen Dank, dass Du Dir die Zeit nimmst, uns mit Deinem Wissen zu unterstützen. Zu den folgenden Fragen würden wir gern Deine Meinung für die Beratung in der Selbstmedikation wissen.', 
            1)
            ->addModule('text-paragraph', 
                'Wenn Sie an den Verkauf von OTC-Produkten / Nahrungsergänzungsmitteln denken, könnten Sie den Beratungsaufwand je nach Kunde und Produktgruppe deutlich unterscheiden? (Bitte denke an Dein Tagesgeschäft und gebe an, wie hoch Dein Beratungsaufwand innerhalb der folgenden Produktgruppen ist)', 
            2)
            ->addModule('single-choice', [
                'question' => 'Topische Schmerzmittel',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 2)
            ->addModule('single-choice', [
                'question' => 'Erkältungsprodukte, planzlich',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 2)
            ->addModule('single-choice', [
                'question' => 'Erkältungsprodukte, chemisch',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 2)
            ->addModule('single-choice', [
                'question' => 'Schwangerschaftsvitamine',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 2)
            ->addModule('single-choice', [
                'question' => 'Vitamin D',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 2)
            ->addModule('single-choice', [
                'question' => 'Nasenspray',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 2)
            ->addModule('text-paragraph', 
                'Wie viele Deiner Kunden haben schon eine konkrete Marke / ein konkretes Produkt im Kopf? (Bitte denke wieder an Dein Tagesgeschäft und gebe pro Produktgruppe an, wie viele Deiner Kunden eine konkrete Marke / ein konkretes Produkt verlangen)', 
            3)
            ->addModule('single-choice', [
                'question' => 'Topische Schmerzmittel',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'Erkältungsprodukte, planzlich',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'Erkältungsprodukte, chemisch',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'Schwangerschaftsvitamine',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'Vitamin D',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'Nasenspray',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 3)
            ->addModule('text-paragraph', 
                'Was beeinflusste Deine Kunden am meisten beim Kauf? (Bitte denke wieder an dein Tagesgeschäft und teile uns pro Produktgruppe mit, was deine Kunden bei einer konkreten Marke / einem konkreten Produkt am stärksten beeinflusst)', 
            4)
            ->addModule('single-choice', [
                'question' => 'Empfehlung des Arztes / grünes Rezept',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 4)
            ->addModule('single-choice', [
                'question' => 'Werbung außerhalb der Apotheke (TV, Zeitschriften, Internet)',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 4)
            ->addModule('single-choice', [
                'question' => 'Werbung in der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 4)
            ->addModule('single-choice', [
                'question' => 'Zufriedenheit mit dem Produkt',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 4)
            ->addModule('single-choice', [
                'question' => 'Empfehlung der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 4)
            ->addModule('text-paragraph', 
                'Was beeinflusste Deine Kunden am meisten beim Kauf? (Bitte denke wieder an dein Tagesgeschäft und teile uns pro Produktgruppe mit, was deine Kunden bei einer konkreten Marke / einem konkreten Produkt am stärksten beeinflusst)', 
            5)
            ->addModule('single-choice', [
                'question' => 'Empfehlung des Arztes / grünes Rezept',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Werbung außerhalb der Apotheke (TV, Zeitschriften, Internet)',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Werbung in der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Zufriedenheit mit dem Produkt',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Empfehlung der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 5)
            ->addModule('text-paragraph', 
                'Was beeinflusste Deine Kunden am meisten beim Kauf? (Bitte denke wieder an dein Tagesgeschäft und teile uns pro Produktgruppe mit, was deine Kunden bei einer konkreten Marke / einem konkreten Produkt am stärksten beeinflusst)', 
            6)
            ->addModule('single-choice', [
                'question' => 'Empfehlung des Arztes / grünes Rezept',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 6)
            ->addModule('single-choice', [
                'question' => 'Werbung außerhalb der Apotheke (TV, Zeitschriften, Internet)',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 6)
            ->addModule('single-choice', [
                'question' => 'Zufriedenheit mit dem Produkt',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 6)
            ->addModule('single-choice', [
                'question' => 'Werbung in der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 6)
            ->addModule('single-choice', [
                'question' => 'Empfehlung der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 6)
            ->addModule('text-paragraph', 
                'Was beeinflusste Deine Kunden am meisten beim Kauf? (Bitte denke wieder an dein Tagesgeschäft und teile uns pro Produktgruppe mit, was deine Kunden bei einer konkreten Marke / einem konkreten Produkt am stärksten beeinflusst)', 
            7)
            ->addModule('single-choice', [
                'question' => 'Empfehlung des Arztes / grünes Rezept',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 7)
            ->addModule('single-choice', [
                'question' => 'Werbung außerhalb der Apotheke (TV, Zeitschriften, Internet)',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 7)
            ->addModule('single-choice', [
                'question' => 'Werbung in der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 7)
            ->addModule('single-choice', [
                'question' => 'Zufriedenheit mit dem Produkt',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 7)
            ->addModule('single-choice', [
                'question' => 'Empfehlung der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 7)
            ->addModule('text-paragraph', 
                'Was beeinflusste Deine Kunden am meisten beim Kauf? (Bitte denke wieder an dein Tagesgeschäft und teile uns pro Produktgruppe mit, was deine Kunden bei einer konkreten Marke / einem konkreten Produkt am stärksten beeinflusst)', 
            8)
            ->addModule('single-choice', [
                'question' => 'Empfehlung des Arztes / grünes Rezept',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 8)
            ->addModule('single-choice', [
                'question' => 'Werbung außerhalb der Apotheke (TV, Zeitschriften, Internet)',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 8)
            ->addModule('single-choice', [
                'question' => 'Werbung in der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 8)
            ->addModule('single-choice', [
                'question' => 'Zufriedenheit mit dem Produkt',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 8)
            ->addModule('single-choice', [
                'question' => 'Empfehlung der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 8)
            ->addModule('text-paragraph', 
                'Was beeinflusste Deine Kunden am meisten beim Kauf? (Bitte denke wieder an dein Tagesgeschäft und teile uns pro Produktgruppe mit, was deine Kunden bei einer konkreten Marke / einem konkreten Produkt am stärksten beeinflusst)', 
            9)
            ->addModule('single-choice', [
                'question' => 'Empfehlung des Arztes / grünes Rezept',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 9)
            ->addModule('single-choice', [
                'question' => 'Werbung außerhalb der Apotheke (TV, Zeitschriften, Internet)',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 9)
            ->addModule('single-choice', [
                'question' => 'Werbung in der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 9)
            ->addModule('single-choice', [
                'question' => 'Zufriedenheit mit dem Produkt',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 9)
            ->addModule('single-choice', [
                'question' => 'Empfehlung der Apotheke',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 9)
            ->addModule('text-paragraph', 
                'Wenn du jetzt eine Situation in der Gruppe der Schwangerschaftsvitamine denkst. Wie oft kommt es vor, dass Ihre Kundinnen von Ihrem Kaufwunsch (bspw. Empfehlung vom Arzt oder Freundin), mit dem Sie in die Apotheke kommen, abweichen und am Ende ein alternatives Produkt kaufen? Sag dies bitte für die folgenden Marken.', 
            10)
            ->addModule('single-choice', [
                'question' => 'Femibion',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 10)
            ->addModule('single-choice', [
                'question' => 'Elevit',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 10)
            ->addModule('single-choice', [
                'question' => 'Folio',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 10)
            ->addModule('single-choice', [
                'question' => 'Orthomol Natal',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 10)
            ->addModule('text-paragraph', 
                'Wir bleiben in der Gruppe der Schwangerschaftsvitamine. Gibt es Produkte, bei denen du häufiger aktiv wirst und eine Alternativempfehlung aussprichst? Sag, dies bitte für die folgenden Produkte und begründe ganz kurz warum.', 
            11)
            ->addModule('single-choice', [
                'question' => 'Femibion',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 11)
            ->addModule('single-choice', [
                'question' => 'Elevit',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 11)
            ->addModule('single-choice', [
                'question' => 'Folio',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 11)
            ->addModule('single-choice', [
                'question' => 'Orthomol Natal',
                'options' => ['Sehr niedrig', 'eher niedrig', 'Eher hoch', 'Sehr hoch'],
            ], 11)

            ->addModule('text-paragraph', 
                'Denke bitte an das Produkt, für das Du am häufigsten eine Alternative empfiehlst. Kannst Du es benennen und der empfohlenen Alternative?', 
            12)
            ->addModule('answer-single-line', [
                'question' => 'Erstempfehlung'
            ], 12)
            ->addModule('answer-single-line', [
                'question' => 'Gekauftes Produkt (Alternative)'
            ], 12);

        return $this;
    }

}