<?php

namespace app\controllers;

use app\classes\CSRFToken;
use app\classes\DeniedAcess;
use app\core\Controller;
use app\facade\App;
use app\requests\LoginRequest;
use app\services\Auth\AuthService;
use app\services\Redirect;
use app\services\Response;

class LoginController extends Controller{

    public function __construct(
        protected LoginRequest $loginRequest,
        protected AuthService $auth
    )
    {
    }
    
    public function index(): Response {
                          
        
            $request = $this->loginRequest->validated();
     
            if(!$request){
                return new DeniedAcess('Verifique os campos e tente novamente.');
            }
            
            $data = $request->data();

            $user = $this->auth->execute($data);

            if(!$user){
                return new DeniedAcess('E-mail ou senha incorreto.');
            }

            if(strtolower($user->ativo) !== "sim"){
                return new DeniedAcess('O seu acesso está bloqueado, pois o seu perfil não está ativo.');
            }

            App::authSession()->init($user);

            return new Redirect('/dashboard');
        
    }


    public function logout(): Response{

        App::authSession()->end();

        return new Redirect("/", 302);

    }

}