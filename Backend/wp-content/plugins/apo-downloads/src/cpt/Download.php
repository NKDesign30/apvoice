<?php

namespace dwnld\cpt;
use awsm\wp\libraries\cpt\CustomPostType;

class Download extends CustomPostType
{

    /**
     * Defines the slug with which the custom-post-type is registered
     */
    const SLUG = 'downloads';
    
    public function __construct()
    {
        $this->initalizeCustomPostType();
        parent::__construct(self::SLUG);
    }

    public function initalizeCustomPostType()
    {
        $this->initalizeArguments()
            ->initalizeProductTaxonomyArguments()
            ->initalizeCategoryTaxonomyArguments()
            ->initalizeMediatypeTaxonomyArguments();
        return $this;
    }

    /**
     * List of all arguments
     * @link https://codex.wordpress.org/Function_Reference/register_post_type
     */
    public function initalizeArguments()
    {
        $labels = array(
            'name' => __('Downloads', 'dwnld'),
            'singular_name' => __('Download', 'dwnld'),
            'all_items' => __('Show Downloads', 'dwnld'),
            'add_new_item' => __('Add Download', 'dwnld'),
            'add_new' => __('Add Download', 'dwnld'),
        );

        $args = array(
            'label' => __('Downloads', 'dwnld'),
            'description' => __('Start with Downloads', 'dwnld'),
            'labels' => $labels,
            'supports' => array('title', 'revisions', 'custom-fields'),
            'public' => true,
            'exclude_from_search' => false,
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-media-archive',
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

    public function initalizeCategoryTaxonomyArguments()
    {
        $arguments = [
            'hierarchical' => true,
            'label' => __('Category', 'dwnld'),
            'public' => true,
            'show_in_rest' => true,
            'show_in_menu' => false,
            'show_ui' => false,
        ];

        $this->setTaxonomyArguments('dwnld-category', $arguments);
        return $this;
    }

    public function initalizeProductTaxonomyArguments()
    {
        $arguments = [
            'hierarchical' => true,
            'label' => __('Product', 'dwnld'),
            'public' => true,
            'show_in_rest' => true,
        ];

        $this->setTaxonomyArguments('dwnld-product', $arguments);
        return $this;
    }

    public function initalizeMediatypeTaxonomyArguments()
    {
        $arguments = [
            'hierarchical' => true,
            'label' => __('Mediatype', 'dwnld'),
            'public' => true,
            'show_in_rest' => true,
        ];

        $this->setTaxonomyArguments('dwnld-mediatype', $arguments);
        return $this;
    }
 
}