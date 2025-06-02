<?php

namespace app\controllers\dashboard;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class FrequenciasController{

    public function index(Request $req, Response $res){
        return $res->view('dashboard/template',[
            'title' => 'Frequências',
            'view' => 'dashboard/frequencias/index',
        ]);
    }

}
