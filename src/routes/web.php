<?php

use app\core\Router;
use app\middlewares\AuthMiddleware;
use app\middlewares\CSRFMiddleware;
use app\middlewares\RoleMiddleware;

Router::group([
    'prefix' => '/dashboard',
    'middlewares' => [AuthMiddleware::class, RoleMiddleware::class]
],function($route){
    $route('GET','', "dashboard\HomeController@index");
    $route('GET', "/usuarios", 'dashboard\UsuariosController@index');
    $route('GET', "/grupoacessos", 'dashboard\GrupoAcessosController@index');
    $route('GET', "/acessos", 'dashboard\AcessosController@index');
});


Router::get("/", 'HomeController@index');
// Router::get("/dashboard", 'dashboard\HomeController@index', [AuthMIddleware::class]);

Router::post("/login", 'LoginController@index', [CSRFMiddleware::class]);
Router::get("/logout", 'LoginController@logout');