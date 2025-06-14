<?php

namespace app\controllers\dashboard;

use app\core\Request;
use app\core\Response;
use app\classes\CSRFToken;




class GrupoAcessosController{
    
    public function __construct(
        private CSRFToken $csrfToken
    )
    {
        
    }

    public function index(Request $request, Response $res){

        $token = $this->csrfToken->generateToken();
        return $res->view('dashboard/template', [
            'title' => 'Grupo de acessos',
            'token_csrf' => $token,
            'view' => 'dashboard/grupo_acessos/index'
        ]);
    }

}