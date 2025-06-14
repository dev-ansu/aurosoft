<?php

namespace app\controllers\dashboard;

use app\core\Request;
use app\core\Response;
use app\core\Controller;
use app\services\Cargos\CargosService;

class UsuariosController extends Controller{

    public function __construct(
        private CargosService $cargosService
    )
    {
        
    }
  
    public function index(Request $req, Response $res){

        $cargos = $this->cargosService->fetchAll()->toArray()['data'];

        $res->view('dashboard/template', [
            'title' => 'Usuários',
            'cargos' => $cargos,
            'view' => 'dashboard/usuarios/index'
        ]);
    }

}