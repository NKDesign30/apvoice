<?php

namespace awsm\wp\libraries\utilities;

trait Migratable
{   

    protected $networkWide;
    protected $schemas;
    protected $primaryBlogSchemas;

    public function up()
    {
        $this->storeTables();
        return $this;
    }

    public function createTablesForNewBlog($blogId)
    {
        switch_to_blog( $blogId );
        $this->createTables();
        restore_current_blog();
        return $this;
    }

    protected function addSchema($schema)
    {
        $this->schemas[] = $schema;
        return $this;
    }

    protected function addPrimaryBlogSchema($schema)
    {
        $this->primaryBlogSchemas[] = $schema;
        return $this;
    }

    protected function storeTables() 
	{
        if( is_multisite() && $this->networkWide ) {
            $this->createTablesForMultisite();
        } else {
            $this->createTables();
        }

        $this->createTablesOnlyForPrimaryBlog();

        return $this;
    }

    protected function createTables()
    {
        $this->createSchemas();

        foreach ($this->schemas as $schema) {
            $this->db->createTable($schema);
        }
        return $this;
    }

    protected function createTablesForMultisite()
    {
        foreach ( $this->getBlogIds() as $id ) {
            switch_to_blog( $id );
            $this->createTables();
            restore_current_blog();
        }
        return $this;
    }

    protected function createTablesOnlyForPrimaryBlog()
    {
        if(method_exists($this, 'createPrimaryBlogSchemas')) {
            $this->createPrimaryBlogSchemas();
            switch_to_blog( get_network()->site_id );

            foreach ($this->primaryBlogSchemas as $schema) {
                $this->db->createTable($schema);
            }
            restore_current_blog();
        }
        return $this;
    }

    protected function getBlogIds()
    {
        return array_map(function($blog) {
            return $blog->blog_id;
        }, get_sites());
    }
}