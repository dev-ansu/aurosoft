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
    $route("GET", '/grupoacessos', 'api\GrupoAcessosController@index');
    $route("POST", '/grupoacessos/insert', 'api\GrupoAcessosController@insert', [CSRFMiddleware::class]);
    $route("POST", '/grupoacessos/patch', 'api\GrupoAcessosController@patch', [CSRFMiddleware::class]);
    $route("GET", '/grupoacessos/delete/{id:\d+}', 'api\GrupoAcessosController@delete');

    // Rotas de acessos
    $route("GET", '/acessos', 'api\AcessosController@index');
    $route("GET", '/acessos/delete/{id:\d+}', 'api\AcessosController@delete', [CSRFMiddleware::class]);
    $route("POST", '/acessos/insert', 'api\AcessosController@insert', [CSRFMiddleware::class]);
    $route("POST", '/acessos/patch', 'api\AcessosController@patch', [CSRFMiddleware::class]);

    // Rotas de permissões
    $route("POST", "/permissoes", "api\PermissoesController@index", [CSRFMiddleware::class]);

});