<?php

namespace app\controllers;

use app\classes\CSRFToken;
use app\services\Request;
use app\services\Response;

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