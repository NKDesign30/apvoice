<?php 
namespace apo\reporting\utilities;

trait CreateStatsTrait 
{
    public function createStats($stats)
    {
        $data = array_combine(array_keys( (array) $stats ), (array) $stats);

        // convert all null values to 0
        array_walk_recursive( $data, function(&$value) {
            if (is_null($value)) $value = 0;
        });
        
        return $this->createOrUpdate($data);
    }

}