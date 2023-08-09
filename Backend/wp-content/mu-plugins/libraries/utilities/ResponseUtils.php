<?php

namespace awsm\wp\libraries\utilities;
use awsm\wp\libraries\utilities\Collector;

trait ResponseUtils 
{   
    use Collector;

    public function prepareResponse($response)
    {
        if(is_string($response)) return $this->decodeSerilizedValue($response);

        $response = json_decode(json_encode($response), true);
        
        if($this->isMultidimensionalArray($response)) {
            foreach ($response as $data) {
                $this->collect($this->prepareSerializedValues($data));
            }
            return $this->getCollection();
        } else {
            return $this->prepareSerializedValues($response);
        }      
    }

    private function prepareSerializedValues($values)
    {
        if(!is_array($values))
            return $values;
            
        return array_map(function($data) {
            return $this->decodeSerilizedValue($data);
        }, $values);
    }

    private function decodeSerilizedValue($value)
    {
        return maybe_unserialize($value);
    }

    protected function isMultidimensionalArray($array)
    {
        return is_array($array) && (count($array) != count($array, COUNT_RECURSIVE));
    }
}