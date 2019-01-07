<?php

namespace Quentn;

abstract class AbstractQuentnApi {
    
    protected $client; 

    public function __construct(QuentnPhpSdkClient $client)
    {
        $this->client = $client;
    }

}