<?php

namespace app\controllers\dashboard;

use app\core\Request;
use app\core\Response;

class HomeController{

    public function index(Request $req, Response $res){
        
        return $res->view('dashboard/template',[
            'title' => 'Dashboard',
            'view' => 'dashboard/index',
        ]);
    }

}