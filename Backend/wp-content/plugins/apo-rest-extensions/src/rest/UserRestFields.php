<?php

namespace apo\rxts\rest;

use awsm\wp\libraries\rest\RegisterRestField;
use apo\rxts\controllers\UserPharmaciesController;
use apo\rxts\controllers\UserLoginActivityController;
use apo\rxts\controllers\UsersController;
use apo\svy\controllers\ResultsSurveyController;
use apo\trng\controllers\ResultsTrainingController;

class UserRestFields extends RegisterRestField
{

    public function __construct()
    {
        parent::__construct('user');
    }

    public function register()
    {
        $this->registerAssociatedPharmacies()
            ->registerLoginActivity()
            ->registerNewsletterState()
            ->registerUserRoles()
            ->registerSurveyResults()
            ->registerTrainingResults()
            ->registerHasUpdatedPharmacyAddress();
    }

    public function registerAssociatedPharmacies()
    {
        $this->registerRestField('associated_pharmacies', [
            'get_callback' => [new UserPharmaciesController, 'index'],
            'schema' => array(
                'description' => 'Show pharmacies result for the given user',
                'type'        => 'array'
            ),
        ]);
        return $this;
    }

    public function registerLoginActivity()
    {
        $this->registerRestField('login_activity', [
            'get_callback' => [new UserLoginActivityController, 'show'],
            'schema' => array(
                'description' => 'Show the percentage login activity for the given user',
                'type'        => 'array'
            ),
        ]);
        return $this;
    }

    public function registerNewsletterState()
    {
        $this->registerRestField('newsletter_state', [
            'get_callback' => [new UsersController, 'newsletterState'],
            'schema' => array(
                'description' => 'Current state of Newsletter subscription',
                'type'        => 'array'
            ),
            ]);
        return $this;
    }

    public function registerSurveyResults()
    {
        $this->registerRestField('survey_results', [
            'get_callback' => [new ResultsSurveyController, 'getSurveyResults'],
            'schema' => array(
                'description' => 'List the Results of finished Surveys',
                'type'        => 'array'
            ),
        ]);
        return $this;
    }

    public function registerTrainingResults()
    {
        $this->registerRestField('training_results', [
            'get_callback' => [new ResultsTrainingController, 'getTrainingResults'],
            'schema' => array(
                'description' => 'List the Results of finished Training',
                'type'        => 'array'
            ),
        ]);
        return $this;
    }

    public function registerUserRoles()
    {
        $this->registerRestField('roles', [
            'get_callback' => function() {
                return get_userdata( get_current_user_id() )->roles;
            },
            'schema' => array(
                'description' => 'Show all roles for the given user',
                'type'        => 'array'
            ),
        ]);
        return $this;
    }

    public function registerHasUpdatedPharmacyAddress()
    {
        $this->registerRestField('has_updated_pharmacy_address', [
            'get_callback' => function() {
                return rxts_verify_user_has_updated_pharmarcy_address(get_current_user_id());
            },
            'schema' => array(
                'description' => 'Checks if the current user has updated the pharmacy address',
                'type'        => 'boolean'
            ),
        ]);
        return $this;
    }
}
