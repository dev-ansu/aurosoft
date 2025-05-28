<?php

namespace app\controllers\dashboard;

use app\classes\CSRFToken;
use app\core\Controller;
use app\services\Response;

class UsuariosController extends Controller{

  
    public function index(): Response{

        return new Response(
            $this->load('dashboard/template', [
                'title' => 'Usuários',
                'view' => 'dashboard/usuarios/index'
            ])
        );
    }

}