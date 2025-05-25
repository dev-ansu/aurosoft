<?php

namespace app\controllers;

use app\classes\CSRFToken;
use app\classes\Session;
use app\core\Controller;
use app\services\Response;

class HomeController extends Controller{
    
    public function index(): Response{
        $csrf = new CSRFToken();
        // (new Session)->unset(SESSION_LOGIN);
        $token = $csrf->getToken();
        return new Response(
            $this->load('template-login', [
                'title' => 'Projeto',
                'token' => $token,
                'view' => 'login'
            ])          
        );
    }

    public function teste():Response{
        return new Response(
            'Teste',
        );
    }

}