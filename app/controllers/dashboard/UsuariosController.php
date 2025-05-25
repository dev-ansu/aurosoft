<?php

namespace app\controllers\dashboard;
use app\core\Controller;


class UsuariosController extends Controller{

  
    public function index(){
        $this->load('dashboard/template', [
            'title' => 'Usuários',
            'view' => 'dashboard/usuarios/index'
        ]);
    }

}