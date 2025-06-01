<?php

namespace app\controllers\dashboard;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class ContasReceberController{

    public function index(Request $req, Response $res){

        
        return $res->view('dashboard/template',[
            'title' => 'Contas a receber',
            'view' => 'dashboard/contas_receber/index'
        ]);
    }

}
