<?php

namespace app\controllers\dashboard;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\services\FormasPagamento\FormasPagamentoService;
use app\services\Frequencias\FrequenciasService;

class ContasPagarController{

    public function __construct(
        private FormasPagamentoService $formasPagamentoService, 
        private FrequenciasService $frequenciasService)
    {
        
    }

    public function index(Request $req, Response $res){
        $formasPgto = $this->formasPagamentoService->fetchAll()->toArray()['data'];
        $frequencias = $this->frequenciasService->fetchAll()->toArray()['data'];
        
        return $res->view('dashboard/template',[
            'title' => 'Contas a pagar',
            'formasPgto' => $formasPgto,
            'frequencias' => $frequencias,
            'view' => 'dashboard/contas_pagar/index'
        ]);
    }

}
