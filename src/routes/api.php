<?php

use app\controllers\api\AcessosController;
use app\controllers\api\ConfigController;
use app\controllers\api\GrupoAcessosController;
use app\controllers\api\PermissoesController;
use app\controllers\api\UsuariosController;
use app\core\Router;
use app\middlewares\AuthMiddleware;
use app\middlewares\CSRFMiddleware;

Router::group([
    'prefix' => '/api',
    'middlewares' => [AuthMiddleware::class]
],function($route){
    
    // Rotas de usuário
    $route('GET', "/usuarios", [UsuariosController::class, 'index']);
    $route('GET', "/usuarios/delete/{id:\d+}",[UsuariosController::class, 'delete']);
    $route('GET', "/usuarios/activate/{id:\d+}", [UsuariosController::class, 'activate']);
    $route('GET', "/usuarios/deactivate/{id:\d+}", [UsuariosController::class, 'deactivate']);
    $route('POST', "/usuarios/insert", [UsuariosController::class, 'insert'], [CSRFMiddleware::class]);
    $route('POST', "/usuarios/patch", [UsuariosController::class, 'patch'], [CSRFMiddleware::class]);

    // Rotas das configurações
    $route("POST", '/config', [ConfigController::class,'index']);

    // Rotas de grupo de acessos
    $route("GET", '/grupoacessos',[GrupoAcessosController::class, 'index']);
    $route("POST", '/grupoacessos/insert',[GrupoAcessosController::class, 'insert'], [CSRFMiddleware::class]);
    $route("POST", '/grupoacessos/patch',[GrupoAcessosController::class, 'patch'], [CSRFMiddleware::class]);
    $route("GET", '/grupoacessos/delete/{id:\d+}',[GrupoAcessosController::class, 'delete']);

    // Rotas de acessos
    $route("GET", '/acessos',[AcessosController::class, 'index']);
    $route("GET", '/acessos/delete/{id:\d+}',[AcessosController::class, 'delete'], [CSRFMiddleware::class]);
    $route("POST", '/acessos/insert', [AcessosController::class, 'insert'], [CSRFMiddleware::class]);
    $route("POST", '/acessos/patch', [AcessosController::class, 'patch'], [CSRFMiddleware::class]);

    // Rotas de permissões
    $route("POST", "/permissoes",[PermissoesController::class, 'index'], [CSRFMiddleware::class]);
    $route("POST", "/permissoes/insert",[PermissoesController::class, 'insert'], [CSRFMiddleware::class]);
    $route("POST", "/permissoes/insertAll", [PermissoesController::class, 'insertAll'], [CSRFMiddleware::class]);

});