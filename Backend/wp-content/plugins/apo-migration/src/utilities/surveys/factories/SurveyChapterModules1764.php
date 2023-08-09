<?php 
namespace apo\migration\utilities\surveys\factories;

use apo\migration\utilities\surveys\factories\AbstractSurveyChapterModuleFactory;

class SurveyChapterModules1764 extends AbstractSurveyChapterModuleFactory 
{
    
    /**
     * Creates a new instance of SurveyChapterModules1764
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
                'eLearnings sind heutzutage ein gängiges Medium, um sich schnell und ortsunabhängig Wissen anzueignen. Wir würden gerne Deine Meinung zu diesem Thema mit den folgenden Fragen erfahren.', 
            1)
            ->addModule('answer-single-line', [
                'question' => 'Wenn Du in einem Satz beschreiben müsstest was deinen Apothekenalltag verbessern würde, wie würde dieser Satz lauten?'
            ], 2)
            ->addModule('answer-single-line', [
                'question' => 'Beschreibe in drei Worten, wofür apovoice für dich steht.'
            ], 2)
            ->addModule('answer-single-line', [
                'question' => 'Welche drei Stichwörter fallen Dir dazu ein, was die größten Vorteile von apovoice sind.'
            ], 2)
            ->addModule('answer-single-line', [
                'question' => 'Wenn apovoice eine menschliche Person wäre, nenne uns EINE Eigenschaft, die sie beschreiben würde.'
            ], 2)
            ->addModule('text-paragraph', 
                'Welche der hier genannten Social Media Plattformen nutzt du?', 
            3)
            ->addModule('single-choice', [
                'question' => 'Facebook',
                'options' => ['ja', 'nein'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'TikTok',
                'options' => ['ja', 'nein'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'Instagram',
                'options' => ['ja', 'nein'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'Snapchat',
                'options' => ['ja', 'nein'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'XING',
                'options' => ['ja', 'nein'],
            ], 3)
            ->addModule('single-choice', [
                'question' => 'Linkedin',
                'options' => ['ja', 'nein'],
            ], 3)
            ->addModule('answer-single-line', [
                'question' => 'Welchen drei Marken oder Influencern folgst Du, weil dich ihre Inhalte interessieren?'
            ], 4)
            ->addModule('text-paragraph', 
                'Welche der hier genannten Online-Plattformen nutzt Du außer apovoice noch?', 
            5)
            ->addModule('single-choice', [
                'question' => 'PTA Channel',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Apothekia',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Marpinion',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'PTA heute',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'GEHE',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Thomae Akademie',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Ratiopharm',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Almased',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Schwabe',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Bionorica',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Pro Medica',
                'options' => ['ja', 'nein'],
            ], 5)
            ->addModule('single-choice', [
                'question' => 'Ich bin',
                'options' => ['unter 20 Jahre alt', 'zwischen 20-30 Jahre alt', 'zwischen 31- 40 Jahre alt', 'zwischen 41-50 Jahre alt', 'über 50 Jahre alt'],
            ], 6)
            ->addModule('single-choice', [
                'question' => 'Ich bin',
                'options' => ['männlich', 'weiblich', 'diverse'],
            ], 6)
            ->addModule('single-choice', [
                'question' => 'Meine Berufsbezeichnung',
                'options' => ['PTA', 'OKA', 'Apotheker(in)'],
            ], 6);

        return $this;
    }

}