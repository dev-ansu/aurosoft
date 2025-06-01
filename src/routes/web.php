<?php

use app\controllers\dashboard\AcessosController;
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
    $route->get('', [HomeController::class, 'index']);
    $route->get("/usuarios", [UsuariosController::class, 'index']);
    $route->get("/grupoacessos", [GrupoAcessosController::class, 'index']);
    $route->get("/acessos", [AcessosController::class, 'index']);
});


Router::get("/", [ControllersHomeController::class, 'index']);
Router::get("/teste", [TesteController::class, 'index']);

Router::post("/login", [LoginController::class, 'index'], [CSRFMiddleware::class]);
Router::get("/logout", [LoginController::class, 'logout']);