<?php

use app\core\Router;
use app\middlewares\AuthMiddleware;
use app\middlewares\CSRFMiddleware;

Router::group([
    'prefix' => '/api',
    'middlewares' => [AuthMiddleware::class]
],function($route){
    $route('GET', "/usuarios", 'api\UsuariosController@index');
    $route('POST', "/usuarios/insert", 'api\UsuariosController@insert', [CSRFMiddleware::class]);
});