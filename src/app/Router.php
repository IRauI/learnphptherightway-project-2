<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes;

    private function register(string $requestMethod, string $route, callable|array $action) : self 
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $path, callable|array $action) : self 
    {
        return $this->register('get', $path, $action);
    }

    public function post(string $path, callable|array $action) : self 
    {
        return $this->register('post', $path, $action);
    }

    public function routes() : array {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod) 
    {
        //takes all the route before the get params
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if(! $action){
            throw new RouteNotFoundException();
        }

        if( is_callable($action)){
            return call_user_func($action);
        }

        if(is_array($action)){
            //splits the action into class and method
            [$class, $method] = $action;
            if(class_exists($class)){
                //creates a new class to call the method on
                $class = new $class;
                if(method_exists($class, $method)){
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new RouteNotFoundException();
    }
}