<?php

namespace app\controllers\dashboard;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\services\Cargos\CargosService;

class CargosController{

    public function __construct(
        private CargosService $cargosService
    )
    {
        
    }

    public function index(Request $req, Response $res){

        $cargos = $this->cargosService->fetchAll()->toArray();
       
        return $res->view('dashboard/template', [
            'title' => 'Cargos',
            'cargos' => $cargos['data'],
            'view' => 'dashboard/cargos/index'
        ]);

    }

}
