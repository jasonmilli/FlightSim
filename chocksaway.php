<?php
function autoLoad ($method) {
    $method = str_replace('\\', '/', strtolower($method));
    chdir(__DIR__);
    require $method.'.php';
}
spl_autoload_register('autoLoad');
$plane = new Plane(0,0,1000,100);
Loop::start($plane);
