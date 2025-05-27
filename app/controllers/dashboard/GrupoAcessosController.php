<?php

namespace app\controllers\dashboard;

use app\classes\CSRFToken;
use app\core\Controller;
use app\facade\App;
use app\services\Config\ConfigService;
use app\services\Response;


class GrupoAcessosController extends Controller{

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
    
    public function __construct(
        private CSRFToken $csrfToken
    )
    {
        
    }

    public function index(): Response{

        $token = $this->csrfToken->generateToken();

        return new Response(
            $this->load('dashboard/template', [
                'title' => 'Grupo de acessos',
                'token_csrf' => $token,
                'view' => 'dashboard/grupo_acessos/index'
            ])
        );
    }

}