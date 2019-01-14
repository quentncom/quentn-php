<?php

namespace Quentn\Client;
use Quentn\Quentn;

abstract class AbstractQuentnClient {
    
    protected $client; 

    public function __construct(Quentn $client)
    {
        $this->client = $client;
    }

}