<?php

namespace app\controllers\dashboard;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\services\formaspagamento\FormasPagamentoService;
use app\services\frequencias\FrequenciasService;

class ContasReceberController{

    public function __construct(
        private FormasPagamentoService $formasPagamentoService, 
        private FrequenciasService $frequenciasService)
    {
        
    }

    public function index(Request $req, Response $res){
        $formasPgto = $this->formasPagamentoService->fetchAll()->toArray()['data'];
        $frequencias = $this->frequenciasService->fetchAll()->toArray()['data'];
        
        return $res->view('dashboard/template',[
            'title' => 'Contas a receber',
            'formasPgto' => $formasPgto,
            'frequencias' => $frequencias,
            'view' => 'dashboard/contas_receber/index'
        ]);
    }

}
