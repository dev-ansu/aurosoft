<?php
namespace app\core;

use Exception;

class RouteCollection{

    private array $routes = [];

    public function add(string $method, string $route, array $action, array $middlewares = []):void{

        $method = strtoupper($method);

        if(count($action) > 2) throw new Exception('O parâmetro action deve ter no máximo dois elementos: [Controller::class, "método"].');

        if(isset($this->routes[$method][$route])) throw new Exception("Rota '$route' já registrada para o método $method.");

        $this->routes[$method][$route] = [
            'action' => $action,
            'middlewares' => $middlewares,
        ];

    }

    public function getAll(){
        return $this->routes;
    }

    public function getByMethod(string $method){
        return $this->routes[$method];
    }

    // Salva o cache das rotas em um arquivo PHP
    public function cache(string $path): void{
        $content = "<?php return " . var_export($this->routes, true) . ";";
        file_put_contents($path, $content);
    }

    public function loadFromCache(string $path){
        if(!file_exists($path)){
            throw new Exception("Arquivo de cache de rotas não encontrado: $path");
        }
        $this->routes = require $path;
    }

}