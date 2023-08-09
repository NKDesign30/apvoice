<?php

namespace apo\svy\cpt;
use awsm\wp\libraries\cpt\CustomPostType;

class Survey extends CustomPostType
{
    /**
     * Defines the slug with which the custom-post-type is registered
     */
    const SLUG = 'surveys';

    /**
     * Define the capability to access the custom post type
     */
    const ACCESS_CAPABILITY = 'manage_surveys';

    /**
     * Define the capability type name
     */
    const CAPABILITY_TYPE_NAME = 'survey';

    public function __construct()
    {
        $this->initalizeArguments();
        parent::__construct(self::SLUG);
    }

    public function initalizeArguments()
    {
        $labels = array(
            'name' => __('Surveys', 'svy'),
            'singular_name' => __('Survey', 'svy'),
            'all_items' =>  __('Show Surveys', 'svy'),
            'add_new_item' =>  __('Add new Survey', 'svy'),
            'add_new' =>  __('Add new Survey', 'svy'),
        );

        $args = array(
            'label' =>  __('Surveys', 'svy'),
            'description' =>  __('Start Survey', 'svy'),
            'labels' => $labels,
            'supports' => array('title', 'revisions', 'custom-fields', 'thumbnail'),
            'public' => true,
            'exclude_from_search' => false,
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-smiley',
            'show_in_rest' => true,
            'rewrite' => false,
            'capability_type' => self::CAPABILITY_TYPE_NAME,
        );
        $this->setArguments($args);
        return $this;
    }
 
}