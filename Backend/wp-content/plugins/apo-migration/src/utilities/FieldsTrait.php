<?php 

namespace apo\migration\utilities;

trait FieldsTrait {

    /**
     * Defines mapping from ACF => human readable
     */
    protected $trainingFieldsMapper = [
        '_trainings' => 'training_group',
        '_trainings_0_training_id' => 'training_id',
        '_trainings_0_year' => 'training_year',
    ];

    /**
     * Defines mapping from ACF => human readable
     */
    protected $informationFieldsMapper = [
        '_informations' => 'informations_group',
        '_informations_description' => 'informations_description',
        '_informations_name' => 'informations_name',
    ];

    /**
     * Defines mapping from ACF => human readable
     */
    protected $surveyFieldsMapper = [
        '_duration' => 'survey_duration_group',
        '_duration_time' => 'survey_duration_time',
        '_duration_type' => 'survey_duration_type',
        '_points' => 'survey_points',
        '_description' => 'survey_description',
        '_chapters' => 'survey_chapters_group',
        '_chapters_0_chapter' => 'survey_chapter_group',
        '_chapters_#_chapter_#_copy' => 'survey_copy',
        '_chapters_#_chapter_#_choices' => 'survey_copy',
    ];

    

    /**
     * All mapped ACF fields to update with the training
     */
    protected $fields = [];

    /**
     * Prepare and map ACF fields for migration
     * @return instance $this
     */
    protected function preapreFields()
    {
        $trainingFields = $this->fetchFieldsByKey('_training');
        $informationFields = $this->fetchFieldsByKey('_informations');
        $lessonFields = $this->fetchFieldsByKey('_lessons');
        $surveyFields = array_merge(
            (array) $this->fetchFieldsByKey('_duration'),
            (array) $this->fetchFieldsByKey('_points'),
            (array) $this->fetchFieldsByKey('_description'),
            (array) $this->fetchFieldsByKey('_chapters'),
        );

        $this->mapFields($trainingFields, $this->trainingFieldsMapper);
        $this->mapFields($informationFields, $this->informationFieldsMapper);
        $this->mapFields($lessonFields, $this->lessonFieldsMapper);
        $this->mapFields($surveyFields, $this->surveyFieldsMapper);

        return $this;
    }

    /**
     * Fetchs unique fields by ACF meta key group
     * In most cases you need prepend an underscore to key
     * 
     * @param String $key
     * 
     * @return Array
     */
    protected function fetchFieldsByKey($key) 
    {
        return $this->unifyFields(
            $this->db->select(
                "SELECT 
                DISTINCT meta_value, meta_key 
            FROM {$this->db->defaultPrefix}postmeta WHERE meta_key LIKE '{$key}%'"
            )
        );
    }

    /**
     * Unify fetched fields by meta value
     * extract fields by unique meta value
     * 
     * @return Array 
     */
    protected function unifyFields($fields)
    {
        $tempFields = array_unique(array_column($fields, 'meta_value'), SORT_REGULAR);

        return array_intersect_key($fields, $tempFields);
    }

    /**
     * Starts to prune unnecessary fields and maps to human readable keys
     * 
     * @param Array $fields
     * @param Array $mapper
     * 
     * @return TrainingsMigrationController
     */
    protected function mapFields($fields, $mapper)
    {
         return $this->createFieldMapping( $this->pruneFields($fields, $mapper), $mapper );
    }

    /**
     * Prune unnecessary fields
     * 
     * @param Array $fields
     * @param Array $mapper 
     * 
     * @return Array 
     */
    protected function pruneFields($fields, $mapper)
    {
         return array_values(array_filter($fields, function($field) use ($mapper) {
            return array_key_exists($field->meta_key, $mapper);
         }));
    }

    /**
     * Map ACF Field keys to human readable keys
     * 
     * @param Array $fields
     * @param Array $mapper
     * 
     * @return TrainingsMigrationController
     */
    protected function createFieldMapping($fields, $mapper)
    {
          foreach ($fields as $field) {
            if(array_key_exists($field->meta_key, $mapper)) {
                $this->fields[$mapper[$field->meta_key]] = $field->meta_value;
            }
         }

         return $this;
    }
}