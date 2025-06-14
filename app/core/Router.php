<?php
namespace app\core;

use Exception;

class Router{
    
    private static ?RouteCollection $collection = null;
    
    public static function init():RouteCollection
    {
        if(!self::$collection){
            self::$collection = new RouteCollection();
        }
        return self::$collection;
    }
    
    public static function get(string $route, array $action, array $middlewares = [], ?string $description = null):void{
        self::init()->add('GET', $route, $action, $middlewares, $description);
    }

    public static function post(string $route, array $action, array $middlewares = [], ?string $description = null): void{
        self::init()->add('POST', $route, $action, $middlewares, $description);
    }

    /**
     * Agrupa rotas com o mesmo prefixo
     * @param array $options - deve-se definir os middlewares que serão usados em todas as rotas e o prefix das rotas
     * @param callable $callback - a função que recebe como parâmetro um $route que definirá as rotas do grupo
     * @return void
     */
    public static function group(array $options, callable $callback): void{
        /**
         * @var array $middlewares - array de middlewares que serão usados nas rotas */
        $middlewares = $options['middlewares'] ?? [];
        /**
         * @var string $prefix - prefixo que será usado em todas as rotas */
        $prefix =  $options['prefix'] ?? '';

        $builder = new RouterBuilder($prefix, $middlewares);

        /** Executa o callback (onde as rotas são definidas) com as opções do grupo
         * @param RouterBuilder $builder - método da requisição GET ou POST */
        $callback($builder);
    }

    public static function resolve(string $url, string $requestMethod): ?array{
        
        $routes = self::$collection->getAll();
        $response = [];
        $matchedUrl = false;
        
        foreach($routes as $method  => $routes){   
            foreach($routes as $route => $action){
                // Converte "{id:\d+}" em "(?P<id>\d+)" e "{slug}" em "(?P<slug>[^/]+)"
                // Converte uma rota com parâmetros nomeados (ex.: /user/{id}) em uma expressão regular.
                // A regex resultante permite extrair os valores dos parâmetros da URL real
                $pattern = preg_replace_callback(
                    '/\{(\w+)(?::([^}]+))?\}/',
                    function ($matches) {
                        $paramName = $matches[1]; // Nome do parâmetro (ex.: id)
                        $regexPattern = $matches[2] ?? '[^/]+'; // Se não houver regex definida, aceita qualquer coisa menos "/"
                        return "(?P<{$paramName}>{$regexPattern})"; // Cria o grupo para capturar o valor da URL
                    },
                    ltrim($route, '/') // Remove a barra inicial da rota
                );
                // Finaliza o padrão regex adicionando delimitadores e âncoras de início/fim.
                $pattern = "#^{$pattern}$#";
                
                if(preg_match($pattern, $url)){
                    if($method === $requestMethod){
                        // MATCH URL e MÉTODO
                        $matches = [];
                        preg_match($pattern, $url, $matches);
                        // Filtra apenas os parâmetros nomeados (ex: 'id' => '123')
                        $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                        array_shift($matches);
                        
                        [$controller, $methodName] = $action['action'];
                                          
                        $response = [
                            'status' => 'FOUND',
                            'controller' => $controller,
                            'method' => $methodName,
                            'params' => $params,
                            'request_method' => $method,
                            'middlewares' => $action['middlewares']
                        ];
                        return $response;
              
                    }else{
                        $matchedUrl = true;
                        $response = [
			    'method' => $route,
                            'status' => 'METHOD_NOT_ALLOWED',
                            'middlewares' => $action['middlewares']
                        ];
                    }
                }
            }

        }

        if($matchedUrl){   
            return $response;
        }
        
        return [
            'status' => 'NOT_FOUND'
        ];
    }

    public static function cache(string $path): void{
        self::init()->cache($path);
    }

    public static function loadFromCache(string $path): void{
        if(!file_exists($path)){
            throw new Exception("Arquivo de cache de rotas não encontrao: $path");
        }

        $routes = require $path;

        $collection = new RouteCollection();

        foreach($routes as $method => $routesByMethod){
            foreach($routesByMethod as $route => $actionData){
                $collection->add($method, $route, $actionData['action'], $actionData['middlewares'], $actionData['description'] ?? null);
            }
        }

        self::$collection = $collection;
    }

}