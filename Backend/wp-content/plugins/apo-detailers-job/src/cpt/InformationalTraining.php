<?php

namespace apo\detailersjob\cpt;
use awsm\wp\libraries\cpt\CustomPostType;

class InformationalTraining extends CustomPostType
{
    /**
     * Defines the slug with which the custom-post-type is registered
     */
    const SLUG = 'ifrmtnl-trng';

     /**
     * Define the capability to access the custom post type
     */
    const ACCESS_CAPABILITY = 'manage_detailers_job';

    /**
     * Define the capability type name
     */
    const CAPABILITY_TYPE_NAME = 'detailersjob';

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
            'name' => __('Detailers Job', 'apovoice-detailers-job'),
            'singular_name' => __('Detailers Job', 'apovoice-detailers-job'),
            'all_items' => __('Show Informational Trainings', 'apovoice-detailers-job'),
            'add_new_item' => __('Add new Informational Training', 'apovoice-detailers-job'),
            'add_new' => __('Add new Informational Training', 'apovoice-detailers-job'),
        );

        $args = array(
            'label' => __('Informational Training', 'apovoice-detailers-job'),
            'description' => __('Start Informational Training', 'apovoice-detailers-job'),
            'labels' => $labels,
            'supports' => array('title', 'revisions', 'custom-fields'),
            'public' => true,
            'exclude_from_search' => false,
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-chart-line',
            'show_in_rest' => true,
            'capability_type' => self::CAPABILITY_TYPE_NAME,
        );

        $this->setArguments($args);

        return $this;
    }
}
