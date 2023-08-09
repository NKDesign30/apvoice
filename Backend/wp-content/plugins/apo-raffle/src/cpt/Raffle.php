<?php

namespace raffle\cpt;
use awsm\wp\libraries\cpt\CustomPostType;

class Raffle extends CustomPostType
{

    /**
     * Defines the slug with which the custom-post-type is registered
     */
    const SLUG = 'raffle';
    
    public function __construct()
    {
        $this->initalizeCustomPostType();
        parent::__construct(self::SLUG);
    }

    public function initalizeCustomPostType()
    {
        $this->initalizeArguments()
            ->initalizeTaxonomyArguments();
        return $this;
    }

    /**
     * List of all arguments
     * @link https://codex.wordpress.org/Function_Reference/register_post_type
     */
    public function initalizeArguments()
    {
        $labels = array(
            'name' => __('Raffle', 'raffle'),
            'singular_name' => __('Raffle', 'raffle'),
            'all_items' => __('Show Raffles', 'raffle'),
            'add_new_item' => __('Add new Raffle', 'raffle'),
            'add_new' => __('Add new Raffle', 'raffle'),
        );

        $args = array(
            'label' => __('Raffle', 'raffle'),
            'description' => __('Start with Raffle', 'raffle'),
            'labels' => $labels,
            'supports' => array('title', 'revisions', 'custom-fields'),
            'public' => true,
            'exclude_from_search' => false,
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-buddicons-groups',
            'show_in_rest' => true,
            'rewrite' => false,
            'capability_type' => 'post',
        );
        $this->setArguments($args);
        return $this;
    }

    /**
     * * List of all arguments
     * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    public function initalizeTaxonomyArguments()
    {
        
    }
 
}