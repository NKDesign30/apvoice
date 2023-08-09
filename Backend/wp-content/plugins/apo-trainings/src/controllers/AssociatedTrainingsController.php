<?php

namespace apo\trng\controllers;

use apo\rxts\metaboxes\UserAccessPermissions;
use apo\trng\controllers\ResultsTrainingController;
use apo\trng\controllers\LessonsController;

class AssociatedTrainingsController
{

    public function associate( $object )
    {
        $associatedTrainings = get_field( 'trainings', $object['id']);

        return array_values(
            array_filter(
                array_map( function($training) use( $object ) {
                    if(!UserAccessPermissions::canAccess($training['training_id'])) return null;
    
                    $fields = get_fields($training['training_id']);
                    return [
                        'training_series_id' => $object['id'],
                        'training' => get_post($training['training_id']),
                        'year' => $training['year'],
                        'globals' => $fields['globals'],
                        'lessons' => $fields['lessons']
                    ];
                }, $associatedTrainings )
            )
        );
    }

} 