<?php

namespace app\controllers;

use app\classes\CSRFToken;
use app\core\Controller;
use app\facade\App;
use app\requests\LoginRequest;
use app\services\Auth\AuthService;

class LoginController extends Controller{

    public function __construct(
        protected LoginRequest $loginRequest,
        protected AuthService $auth
    )
    {
    }
    
    public function index(){
        $csrf = new CSRFToken();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf_token'] ?? '';
                    
            if (!$csrf->validateToken($token)) {
                redirect();
                die('CSRF token inválido ou expirado!');
            }
            $request = $this->loginRequest->validated();
           
            if(!$request){
                $this->denied('message', 'Verifique os campos e tente novamente.');
            }
            
            $data = $request->data();
            $user = $this->auth->execute($data);

            if(!$user){
                $this->denied('message', 'E-mail ou senha incorretos.');
            }

            if(strtolower($user->ativo) !== "sim"){
                $this->denied('message', 'O seu acesso está bloqueado, pois o seu perfil não está ativo.');
            }

            App::authSession()->init($user);
                        
            $csrf->invalidateToken();

            redirect("/dashboard");

        }
    }


    public function logout(){
        App::authSession()->end();
        redirect("/");
    }

}