<?php

namespace App\Core;

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = [
            'GET' => [],
            'POST' => [],
            'PUT' => [],
            'DELETE' => []
        ];
    }

    public function addRoute($method, $path, $function)
    {
        if (!array_key_exists($method, $this->routes) || !is_callable($function) ) {
            die('Oops.. something went wrong. Please contact the administrator');
        } else {
            $this->routes[$method][$path] = $function;
        }
    }

    public function route($method, $path)
    {
        if(
            !array_key_exists($method, $this->routes) || 
            !array_key_exists('/' . $path, $this->routes[$method])
        ) {
            header('HTTP/1.0 404 Not Found');
            header('Content-type: application/json');
            echo json_encode([
                'Status' => 'Error',
                'Data' => 'Not Found'
            ]);
            return false;
        } else {
            return $this->routes[$method]['/' . $path]();
        }
    }
}