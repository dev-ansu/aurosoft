<?php

namespace app\controllers\dashboard;

use app\classes\Session;
use app\contracts\MiddlewareProtected;
use app\core\Controller;
use app\middlewares\AuthMIddleware;
use app\middlewares\RoleMiddleware;
use app\services\Response;

class HomeController extends Controller{

    // public function middlewareMap(): array
    // {
    //     $session = (new Session)->__get(SESSION_LOGIN);
        
    //     return [
    //         'index' => [
    //             AuthMIddleware::class,
    //             [RoleMiddleware::class, [$session->nivel ?? null]]
    //         ],
    //     ];
    // }
    
    public function index(): Response{
        return new Response(
            $this->load('dashboard/template', [
                'title' => 'Dashboard',
                'view' => 'dashboard/index'
            ])
        );
    }

}