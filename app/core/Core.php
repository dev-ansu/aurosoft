<?php

namespace app\core;

use app\controllers\NotFoundHandler;
use app\core\Response;
use DI\Container;


class Core{

    private string $controller = "app\\controllers\\HomeController";
    private string $method = 'index';
    private array $params = [];
 
    public function __construct(private Container $container)
    {
        $this->container = $container;
    }

    public function run(){
        // $url = $this->parseUrl();
        $url = implode("/", $this->parseUrl());
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $route = Router::resolve($url, $requestMethod);

        // Middlewares definidos na ROTA (executados primeiro)
        foreach ($route['middlewares'] ?? [] as $middleware) {
            $middlewareInstance = $this->container->get($middleware);
            $this->container->call([$middlewareInstance, 'handle']);
            // $middlewareInstance->handle();

            // if($response instanceof Response){
            //     $response->send();
            //     return;
            // }
        }
     
        switch ($route['status']){
            case 'NOT_FOUND':
                $notFoundController = $this->container->get(NotFoundHandler::class);
                $this->container->call([$notFoundController, 'handle']);
                break;
            case 'METHOD_NOT_ALLOWED':
                $methodNotAllowed = $this->container->get(Response::class);
                $methodNotAllowed->send("Cannot GET {$route['method']}");
                // return $response->send();
                break;
            default:

                $this->controller = $route['controller'];
                $controller = $this->container->get($this->controller);
                $this->method = $route['method'];
                $this->params = $route['params'];
                $middlewares = $route['middlewares'];

               
                if(isset($middlewares[$this->method])){
                    foreach($middlewares[$this->method] as $middleware){
                        if(is_array($middleware)){
                            [$middlewareClass, $params] = $middleware;
                            $middlewareInstance = $this->container->get($middlewareClass);
                            $this->container->call([$middlewareInstance, 'handle'], $params);
                        }else{
                            $middlewareInstance = $this->container->get($middleware);
                            $this->container->call([$middlewareInstance, 'handle']);
                        }
                    }
                }


                // $this->params = $url;

                // if(!method_exists($controller, $this->method)){
                //     $response = new Response("Esta rota não existe.");
                //     return $response->send();
                //     break;
                // }

                $response = $this->container->call([$controller, $this->method], $this->params);
               
                // $response = call_user_func_array([$controller, $this->method], $this->params);
            
                // if(!$response || !$response instanceof Response){
                //     $controllerName = $controller::class;
                //     throw new \Exception("Response not found in {$controllerName} controller and {$this->method} method.");
                // }
        
                // $response->send();
        }

        
    }

    private function parseUrl(): array {
        $url = urldecode($_SERVER['REQUEST_URI']);
        $basePath = parse_url(BASE_URL, PHP_URL_PATH);
        
        $base = $basePath ? rtrim($basePath, '/'):''; // Adapta para subdiretórios

        if($base !== ''){
            $basePattern = preg_quote($base, '#');
            $url = preg_replace("#^{$basePattern}#", "", $url);
        }
        $url = explode("?", $url)[0];
 
        $url = trim($url, "/");
        return $url ? array_filter(explode("/", $url)) : [];
    }
}