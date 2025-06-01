<?php

use app\controllers\api\AcessosController;
use app\controllers\api\ConfigController;
use app\controllers\api\GrupoAcessosController;
use app\controllers\api\PerfilController;
use app\controllers\api\PermissoesController;
use app\controllers\api\RecuperarSenhaController;
use app\controllers\api\UsuariosController;
use app\core\Router;
use app\core\RouterBuilder;
use app\middlewares\AuthMiddleware;
use app\middlewares\CSRFMiddleware;
use app\middlewares\RoleMiddleware;

Router::group([
    'prefix' => '/api',
    'middlewares' => [AuthMiddleware::class, RoleMiddleware::class]
],function(RouterBuilder $route){
    
    // Rotas de usuário
    $route->get("/usuarios", [UsuariosController::class, 'index']);
    $route->get("/usuarios/delete/{id:\d+}",[UsuariosController::class, 'delete']);
    $route->get("/usuarios/activate/{id:\d+}", [UsuariosController::class, 'activate']);
    $route->get("/usuarios/deactivate/{id:\d+}", [UsuariosController::class, 'deactivate']);
    $route->post("/usuarios/insert", [UsuariosController::class, 'insert'], [CSRFMiddleware::class]);
    $route->post("/usuarios/patch", [UsuariosController::class, 'patch'], [CSRFMiddleware::class]);

    // Rotas de perfil
    $route->post("/perfil", [PerfilController::class, 'index']);

    // Rotas das configurações
    $route->post('/config', [ConfigController::class,'index']);

    // Rotas de grupo de acessos
    $route->get('/grupoacessos',[GrupoAcessosController::class, 'index']);
    $route->post('/grupoacessos/insert',[GrupoAcessosController::class, 'insert'], [CSRFMiddleware::class]);
    $route->post('/grupoacessos/patch',[GrupoAcessosController::class, 'patch'], [CSRFMiddleware::class]);
    $route->get('/grupoacessos/delete/{id:\d+}',[GrupoAcessosController::class, 'delete']);

    // Rotas de acessos
    $route->get('/acessos',[AcessosController::class, 'index']);
    $route->get('/acessos/delete/{id:\d+}',[AcessosController::class, 'delete'], [CSRFMiddleware::class]);
    $route->post('/acessos/insert', [AcessosController::class, 'insert'], [CSRFMiddleware::class]);
    $route->post('/acessos/patch', [AcessosController::class, 'patch'], [CSRFMiddleware::class]);

    // Rotas de permissões
    $route->post("/permissoes",[PermissoesController::class, 'index'], [CSRFMiddleware::class]);
    $route->post("/permissoes/insert",[PermissoesController::class, 'insert'], [CSRFMiddleware::class]);


});

Router::post("/api/recuperarsenha", [RecuperarSenhaController::class, 'index'], [CSRFMiddleware::class]);