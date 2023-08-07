<?php 

namespace apo\expertpoints\verifier;

interface VerifyInterface
{
    public function verify( array $data );
    
    public function verifyByType();
}