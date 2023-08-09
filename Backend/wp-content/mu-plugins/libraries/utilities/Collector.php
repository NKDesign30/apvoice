<?php

namespace awsm\wp\libraries\utilities;

trait Collector 
{   
    private $collection;

    public function collect($data)
    {
        $this->collection[] = $data;
    }

    public function getCollection()
    {
        $returnedCollection = $this->collection;
        $this->clearCollection();
        return $returnedCollection;
    }

    public function clearCollection()
    {
        $this->collection = [];
        return $this;
    }
}