<?php

namespace app\controllers\dashboard;

use app\classes\CSRFToken;
use app\core\Controller;
use app\services\Response;

class UsuariosController extends Controller{

  
    public function index(): Response{
        $token = (new CSRFToken)->generateToken();

        return new Response(
            $this->load('dashboard/template', [
                'title' => 'Usuários',
                'token' => $token,
                'view' => 'dashboard/usuarios/index'
            ])
        );
    }

}