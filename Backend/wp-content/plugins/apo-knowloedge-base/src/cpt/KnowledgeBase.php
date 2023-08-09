<?php

namespace knwldg\cpt;
use awsm\wp\libraries\cpt\CustomPostType;

class KnowledgeBase extends CustomPostType
{

    /**
     * Defines the slug with which the custom-post-type is registered
     */
    const SLUG = 'knowledge-base';
    
    public function __construct()
    {
        $this->initalizeCustomPostType();
        parent::__construct(self::SLUG);
    }

    public function initalizeCustomPostType()
    {
        $this->initalizeArguments();
        return $this;
    }

    /**
     * List of all arguments
     * @link https://codex.wordpress.org/Function_Reference/register_post_type
     */
    public function initalizeArguments()
    {
        $labels = array(
            'name' => __('Knowledge Base', 'knwldg'),
            'singular_name' => __('Knowledge Base', 'knwldg'),
            'all_items' => __('Show Posts', 'knwldg'),
            'add_new_item' => __('Add new Post', 'knwldg'),
            'add_new' => __('Add new Post', 'knwldg'),
        );

        $args = array(
            'label' => __('Knowledge Base', 'knwldg'),
            'description' => __('Start with Knowledge Base', 'knwldg'),
            'labels' => $labels,
            'supports' => array('title', 'revisions', 'custom-fields', 'thumbnail'),
            'public' => true,
            'exclude_from_search' => false,
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-megaphone',
            'show_in_rest' => true,
            'rewrite' => false,
            'capability_type' => 'post',
        );
        $this->setArguments($args);
        return $this;
    } 
}