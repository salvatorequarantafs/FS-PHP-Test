<?php

require_once (__DIR__ . '/vendor/autoload.php');

define('CONFIG_DIR', __DIR__ . '/config');

$router = new App\Core\Router();

$path = \filter_input(INPUT_GET, 'path', FILTER_SANITIZE_ENCODED);

$router->addRoute('GET', '/queue', function(){
    $controller = new App\Controllers\QueueController();
    $controller->getQueue();
});

$router->addRoute('POST', '/queue', function(){
    $controller = new App\Controllers\QueueController();
    $controller->postQueue();
});

$router->route($_SERVER['REQUEST_METHOD'], $path);
