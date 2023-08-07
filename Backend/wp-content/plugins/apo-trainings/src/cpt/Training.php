<?php

namespace apo\trng\cpt;
use awsm\wp\libraries\cpt\CustomPostType;

class Training extends CustomPostType
{
    /**
     * Defines the slug with which the custom-post-type is registered
     */
    const SLUG = 'trainings';

    /**
     * Define the capability to access the custom post type
     */
    const ACCESS_CAPABILITY = 'manage_trainings';

    /**
     * Define the capability type name
     */
    const CAPABILITY_TYPE_NAME = 'training';

    public function __construct()
    {
        $this->initalizeArguments();
        parent::__construct(self::SLUG);
    }

    /**
     * List of all arguments
     * @link https://codex.wordpress.org/Function_Reference/register_post_type
     */
    public function initalizeArguments()
    {
        $labels = array(
            'name' => __('Trainings', 'trng'),
            'singular_name' => __('Training', 'trng'),
            'all_items' => __('Show Trainings', 'trng'),
            'add_new_item' => __('Add new Training', 'trng'),
            'add_new' => __('Add new Training', 'trng'),
        );

        $args = array(
            'label' => __('Training', 'trng'),
            'description' => __('Start Training', 'trng'),
            'labels' => $labels,
            'supports' => array('title', 'revisions', 'custom-fields', 'thumbnail'),
            'public' => true,
            'exclude_from_search' => false,
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => 'apo-trainings',
            'menu_position' => 5,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'show_in_rest' => true,
            'capability_type' => self::CAPABILITY_TYPE_NAME,
        );
        $this->setArguments($args);
        return $this;
    }
 
}