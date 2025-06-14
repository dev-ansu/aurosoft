<?php

use app\controllers\api\AcessosController;
use app\controllers\api\CargosController;
use app\controllers\api\ConfigController;
use app\controllers\api\ContasPagarController;
use app\controllers\api\ContasReceberController;
use app\controllers\api\FormasPagamentoController;
use app\controllers\api\FrequenciasController;
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

    // Rotas de frequencias e formas de pagamento
    $route->get("/formaspagamento", [FormasPagamentoController::class, 'index']);
    $route->get("/formaspagamento/delete/{id:\d+}", [FormasPagamentoController::class, 'delete']);
    $route->get("/formaspagamento/select/{id:\d+}", [FormasPagamentoController::class, 'select']);
    $route->post("/formaspagamento/patch", [FormasPagamentoController::class, 'patch'], [CSRFMiddleware::class]);
    $route->post("/formaspagamento/insert", [FormasPagamentoController::class, 'insert'], [CSRFMiddleware::class]);

    $route->get("/frequencias", [FrequenciasController::class, 'index']);
    $route->get("/frequencias/delete/{id:\d+}", [FrequenciasController::class, 'delete']);
    $route->post("/frequencias/patch", [FrequenciasController::class, 'patch'], [CSRFMiddleware::class]);
    $route->post("/frequencias/insert", [FrequenciasController::class, 'insert'],[CSRFMiddleware::class]);

    // Rotas de permissões
    $route->post("/permissoes",[PermissoesController::class, 'index'], [CSRFMiddleware::class]);
    $route->post("/permissoes/insert",[PermissoesController::class, 'insert'], [CSRFMiddleware::class]);

    // Rotas financeiro
    $route->get("/contasreceber", [ContasReceberController::class, 'index']);
    $route->get("/contasreceber/delete/{id:\d+}", [ContasReceberController::class, 'delete']);
    $route->post("/contasreceber/insert", [ContasReceberController::class, 'insert'], [CSRFMiddleware::class]);
    $route->post("/contasreceber/patch", [ContasReceberController::class, 'patch'], [CSRFMiddleware::class]);
    $route->post("/contasreceber/baixar", [ContasReceberController::class, 'baixar'], [CSRFMiddleware::class]);
    $route->post("/contasreceber/parcelar", [ContasReceberController::class, 'parcelar'], [CSRFMiddleware::class]);

    $route->get("/contasapagar", [ContasPagarController::class, 'index']);
    $route->get("/contasapagar/delete/{id:\d+}", [ContasPagarController::class, 'delete']);
    $route->post("/contasapagar/insert", [ContasPagarController::class, 'insert'], [CSRFMiddleware::class]);
    $route->post("/contasapagar/patch", [ContasPagarController::class, 'patch'], [CSRFMiddleware::class]);
    $route->post("/contasapagar/baixar", [ContasPagarController::class, 'baixar'], [CSRFMiddleware::class]);
    $route->post("/contasapagar/parcelar", [ContasPagarController::class, 'parcelar'], [CSRFMiddleware::class]);

    // Rotas de cargos
    $route->get("/cargos", [CargosController::class, 'index']);
    $route->get("/cargos/delete/{id:\d+}", [CargosController::class, 'delete']);
    
    $route->post("/cargos/insert", [CargosController::class, 'insert']);


});

Router::post("/api/recuperarsenha", [RecuperarSenhaController::class, 'index'], [CSRFMiddleware::class]);