<?php

namespace app\controllers\dashboard;

use app\core\Request;
use app\core\Response;
use app\services\GrupoAcessos\GrupoAcessosService;



class AcessosController{

    
    public function __construct(private GrupoAcessosService $grupoAcessosService)
    {
        
    }

    public function index(Request $req, Response $res){

        $grupos = $this->grupoAcessosService->fetchAll()->toArray();
       
        return $res->view('dashboard/template', [
            'title' => 'Acessos',
            'grupos' => $grupos['data'],
            'view' => 'dashboard/acessos/Index'
        ]);

    }

}