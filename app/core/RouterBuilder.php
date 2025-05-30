<?php
namespace app\core;

class RouterBuilder{

    public function __construct(private string $prefix, private array $groupMiddlewares = [])
    {}

    public function get(string $route, array $action, array $middlewares = []){
        Router::get($this->prefix . $route, $action, array_merge($this->groupMiddlewares, $middlewares));
    }

    public function post(string $route, array $action, array $middlewares = []){
        Router::post($this->prefix . $route, $action, array_merge($this->groupMiddlewares, $middlewares));
    }

}