<?php

namespace app\controllers\dashboard;

use app\classes\CSRFToken;
use app\core\Controller;
use app\services\Request;
use app\services\Response;

class UsuariosController extends Controller{

  
    public function index(Request $req, Response $res){

        $res->view('dashboard/template', [
            'title' => 'Usuários',
            'view' => 'dashboard/usuarios/index'
        ]);
    }

}