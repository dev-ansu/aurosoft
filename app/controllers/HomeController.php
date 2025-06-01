<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\classes\CSRFToken;


class HomeController{
    
    public function index(Request $req, Response $res){
        $csrf = new CSRFToken();
        $token = $csrf->getToken();
        
        return $res->view('template-login', [
            'title' => 'Projeto',
            'token' => $token,
            'view' => 'login'
        ]);
    }

}