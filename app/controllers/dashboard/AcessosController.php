<?php

namespace app\controllers\dashboard;

use app\core\Controller;
use app\services\GrupoAcessos\GrupoAcessosService;
use app\services\Response;


class AcessosController extends Controller{

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
    
    public function __construct(private GrupoAcessosService $grupoAcessosService)
    {
        
    }

    public function index(): Response{

        $grupos = $this->grupoAcessosService->fetchAll()->toArray();
       
        
        return new Response(
            $this->load('dashboard/template', [
                'title' => 'Acessos',
                'grupos' => $grupos['data'],
                'view' => 'dashboard/acessos/Index'
            ])
        );
    }

}