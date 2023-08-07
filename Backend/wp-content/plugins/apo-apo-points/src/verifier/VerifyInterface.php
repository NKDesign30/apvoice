<?php 

namespace apo\apopoints\verifier;

interface VerifyInterface
{
    public function verify( array $data );
    
    public function verifyByType();
}