<?php

use app\core\Router;
use app\middlewares\AuthMiddleware;
use app\middlewares\CSRFMiddleware;

Router::group([
    'prefix' => '/api',
    'middlewares' => [AuthMiddleware::class]
],function($route){
    
    // Rotas de usuário
    $route('GET', "/usuarios", 'api\UsuariosController@index');
    $route('GET', "/usuarios/delete/{id:\d+}", 'api\UsuariosController@delete');
    $route('GET', "/usuarios/activate/{id:\d+}", 'api\UsuariosController@activate');
    $route('GET', "/usuarios/deactivate/{id:\d+}", 'api\UsuariosController@deactivate');
    $route('POST', "/usuarios/insert", 'api\UsuariosController@insert', [CSRFMiddleware::class]);
    $route('POST', "/usuarios/patch", 'api\UsuariosController@patch', [CSRFMiddleware::class]);

    // Rotas das configurações
    $route("POST", '/config', 'api\ConfigController@index');

    // Rotas de grupo de acessos
    $route("POST", '/grupoacessos/insert', 'api\GrupoAcessosController@insert', [CSRFMiddleware::class]);
});