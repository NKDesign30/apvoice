<?php 

namespace awsm\wp\libraries\interfaces;

interface MetaBoxesInterface
{
    public function add();
    public function render( $data );
    public function save( $id );
}