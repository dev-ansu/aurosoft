<?php

use app\controllers\dashboard\AcessosController;
use app\controllers\dashboard\CargosController;
use app\controllers\dashboard\ContasPagarController;
use app\controllers\dashboard\ContasReceberController;
use app\controllers\dashboard\FormasPagamentoController;
use app\controllers\dashboard\FrequenciasController;
use app\controllers\dashboard\GrupoAcessosController;
use app\controllers\dashboard\HomeController;
use app\controllers\dashboard\UsuariosController;
use app\controllers\HomeController as ControllersHomeController;
use app\controllers\LoginController;
use app\controllers\TesteController;
use app\core\Router;
use app\core\RouterBuilder;
use app\middlewares\AuthMiddleware;
use app\middlewares\CSRFMiddleware;
use app\middlewares\RoleMiddleware;

Router::group([
    'prefix' => '/dashboard',
    'middlewares' => [AuthMiddleware::class, RoleMiddleware::class]
],function(RouterBuilder $route){

    // -------- ROTAS PESSOAS -----------//
    $route->get('', [HomeController::class, 'index']);
    $route->get("/usuarios", [UsuariosController::class, 'index']);

    // --------- ROTAS CADASTROS ---------//
    $route->get("/grupoacessos", [GrupoAcessosController::class, 'index']);
    $route->get("/acessos", [AcessosController::class, 'index']);
    $route->get("/formaspagamento", [FormasPagamentoController::class, 'index']);
    $route->get("/frequencias", [FrequenciasController::class, 'index']);

    //------ ROTAS FINANCEIRO --------//
    $route->get("/contasareceber", [ContasReceberController::class, 'index']);
    $route->get("/contasapagar", [ContasPagarController::class, 'index']);

    //------ ROTAS DE CARGOS -----//
    $route->get("/cargos", [CargosController::class, 'index']);

    //------ ROTAS DE FUNCIONÁRIOS -------//
    $route->get('/funcionarios', []);

    //----- ROTAS DE FORNECEDORES -------//
    $route->get("/fornecedores", []);

});


Router::get("/", [ControllersHomeController::class, 'index'], description:'Página de login do Aurosoft.');
Router::get("/teste", [TesteController::class, 'index']);

Router::post("/login", [LoginController::class, 'index'], [CSRFMiddleware::class], description:'Realiza a autenticação do usuário no Aurosoft.');
Router::get("/logout", [LoginController::class, 'logout'], description:'Realiza o logout do usuário no Aurosoft.');