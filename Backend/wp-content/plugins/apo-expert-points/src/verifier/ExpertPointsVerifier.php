<?php 

namespace apo\expertpoints\verifier;

use apo\svy\models\Result as SurveyResult;
use apo\expertpoints\models\ExpertPoint;
use apo\expertpoints\verifier\BaseVerifier;
use apo\expertpoints\verifier\VerifyInterface;

class ExpertPointsVerifier extends BaseVerifier implements VerifyInterface
{

    /**
     * Survey result model
     */
    protected $surveyResult;

    /**
     * Expert point model
     */
    protected $expertPoint;

    public function __construct() 
	{
        parent::__construct();
        $this->surveyResult = new SurveyResult();
        $this->expertPoint = new ExpertPoint();
    }

    public function verify( array $data )
    {
        $this->setAttributes($data);

        if( !$this->isAcceptedType() ) return $this->invalidType();


        if( in_array($this->attributes['relatedType'], $this->skipVerifying) ) {
            return array_merge($data, ['user_id' => $this->userId()]);
        }

        return $this->verifyByType();
    }

    /**
     * verify request by related type
     * add new verify methods here as new related types are added
     */
    public function verifyByType()
    {
        switch ($this->attributes['relatedType']) {
            case 'survey':
                return $this->verifySurvey();
                break;
                
            case 'bonago':
                return $this->verifyBonago();
                break;
            
            default:
                return $this->invalidType();
                break;
        }
    }

    protected function verifySurvey() 
    {
        $surveyResult = $this->surveyResult->showBySurvey($this->attributes['relatedId']);
        if(!$surveyResult || !$surveyResult->is_complete) {
            return $this->forbiddenExpertPointsDistribution();
        }

        $this->attributes['points'] = get_fields($this->attributes['relatedId'])['points'];

        return $this->getVerifiedAttributes();
    }

    protected function verifyBonago() 
    {
        if($this->attributes['points'] > $this->expertPoint->getUsersExpertPoints()) {
            return $this->notEnoughPoints();
        }

        $this->attributes['points'] = -$this->attributes['points'];

        return $this->getVerifiedAttributes();
    }

}