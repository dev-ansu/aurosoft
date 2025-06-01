<?php

namespace app\controllers\dashboard;

use app\core\Request;
use app\core\Response;
use app\core\Controller;



class UsuariosController extends Controller{

  
    public function index(Request $req, Response $res){

 

        $res->view('dashboard/template', [
            'title' => 'Usuários',
            'view' => 'dashboard/usuarios/index'
        ]);
    }

}