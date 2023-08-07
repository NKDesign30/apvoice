<?php 

namespace apo\apopoints\verifier;

use \WP_Error;
use awsm\wp\libraries\utilities\Auth;

class BaseVerifier 
{

    use Auth;

    /**
     * Accepted apo point types
     */
    const ACCEPTED_TYPES = [
        'survey',
        'bonago',
    ];

    /**
     * Skip these types
     */
    protected $skipVerifying = [];

    /**
     * Attributes from incomming request
     * get filled with related keys in attributeMapping
     */
    protected $attributes;

    protected $attributeMapping = [
        'points' => 'points_earned',
        'relatedId' => 'related_id',
        'relatedType' => 'related_type',
    ];

    public function __construct() 
	{

    }

    /**
     * Fill attributes by incomming request data
     */
    protected function setAttributes($data)
    {
        foreach ($this->attributeMapping as $attribute => $key) {
            $this->attributes[$attribute] = $data[$key];
        }

        return $this;
    }

    protected function isAcceptedType()
    {
        return in_array($this->attributes['relatedType'], self::ACCEPTED_TYPES);
    }

    protected function getVerifiedAttributes()
    {
        $this->prepareAttributes();
        return $this->attributes;
    }

    protected function prepareAttributes()
    {
        $attributes = [];
        foreach ($this->attributeMapping as $attribute => $key) {
            $attributes[$key] = $this->attributes[$attribute];
        }
        $this->attributes = $attributes;

        $this->addCurrentUser();

        return $this;
    }

    protected function addCurrentUser()
    {
        $this->attributes['user_id'] = $this->userId();
        return $this;
    }


    /**
     * Error messages
     */

    protected function forbiddenApoPointsDistribution()
    {
        return new WP_Error( 
            "forbidden_apo_point_distribution", 
            "The {$this->attributes['relatedType']} with ID {$this->attributes['relatedId']} is not allowed to distribute apo points", 
            array( "status" => 422 ) 
        );
    }

    protected function invalidType()
    {
        return new WP_Error( 
            "invalid_related_type", 
            "{$this->attributes['relatedType']} is a invalid apo point type", 
            array( "status" => 422 ) 
        );
    }

    protected function notEnoughPoints()
    {
        return new WP_Error( 
            "not_enough_points", 
            "Your total apo points are not enough for this action", 
            array( "status" => 403 ) 
        );
    }
}