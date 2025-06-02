<?php

namespace app\controllers\dashboard;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class FormasPagamentoController{

    public function index(Request $req, Response $res){
        return $res->view('dashboard/template',[
            'title' => 'Formas de pagamento',
            'view' => 'dashboard/formas_pagamento/index',
        ]);
    }

}
