<?php
namespace Quentn;
interface QuentnBase {
    public function call($endPoint, $method = "GET", $vars = null);
    public function test();
}