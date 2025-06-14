<?php
namespace app\core;

class RouterBuilder{

    public function __construct(private string $prefix, private array $groupMiddlewares = [])
    {}

    public function get(string $route, array $action, array $middlewares = [], ?string $description = null){
        Router::get($this->prefix . $route, $action, array_merge($this->groupMiddlewares, $middlewares), $description);
    }

    public function post(string $route, array $action, array $middlewares = [], ?string $description = null){
        Router::post($this->prefix . $route, $action, array_merge($this->groupMiddlewares, $middlewares), $description);
    }

}