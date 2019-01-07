<?php
namespace Quentn;
interface QuentnPHPClientBase {    
    public function call($endPoint, $method = "GET", $vars = null);
    public function test();
}