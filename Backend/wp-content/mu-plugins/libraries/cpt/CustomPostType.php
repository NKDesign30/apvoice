<?php

namespace awsm\wp\libraries\cpt;

class CustomPostType
{
    private $slug;
    private $arguments;
    private $taxonomyArguments;

    public function __construct($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function register()
    {
        $this->registerPostType()
            ->registerTaxonomies();
        return $this;
    }

    protected function registerPostType()
    {
        if($this->arguments) {
            register_post_type($this->slug, $this->arguments);
        }
        return $this;
    }

    protected function registerTaxonomies()
    {
        if($this->taxonomyArguments) {
            foreach ($this->taxonomyArguments as $taxonomy => $args) {
                register_taxonomy( $taxonomy, $this->slug, $args );
            }
        }
        return $this;
    }

    protected function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    protected function setTaxonomyArguments($taxonomy, $arguments)
    {
        $this->taxonomyArguments[$taxonomy] = $arguments;
        return $this;
    }

    protected function getArguments()
    {
        return $this->arguments;
    }

    protected function getTaxonomyArguments()
    {
        return $this->taxonomyArguments;
    }

    protected function getSlug()
    {
        return $this->slug;
    }

}