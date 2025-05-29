<?php

namespace app\controllers;

use app\classes\CSRFToken;
use app\classes\DeniedAcess;
use app\core\Controller;
use app\facade\App;
use app\requests\LoginRequest;
use app\services\Auth\AuthService;
use app\services\Config\ConfigService;
use app\services\permissoes\PermissoesService;
use app\services\Redirect;
use app\services\Request;
use app\services\Response;

class LoginController extends Controller{

    public function __construct(
        protected AuthService $auth,
        private ConfigService $config
    )
    {
    }
    
    public function index(Request $request): Response {

            $validate = $request->post()->validate(LoginRequest::class);
                                
            if($validate['error'] === true){
                return new DeniedAcess('Verifique os campos e tente novamente.');
            }
            
            $data = $validate['issues'];

            $user = $this->auth->execute($data);

            if(!$user){
                return new DeniedAcess('E-mail ou senha incorreto.');
            }

            if(strtolower($user->ativo) !== "sim"){
                return new DeniedAcess('O seu acesso está bloqueado, pois o seu perfil não está ativo.');
            }

            
            $permissoes = (new PermissoesService())->fetchUsuarioPermissoesByUsuarioWithChave($user->id)->toArray()['data'];

            // var_dump($permissoes);
            // die;

            $user->permissoes = $permissoes;
            
            App::authSession()->init($user);
            
                      
            return new Redirect('/dashboard');
        
    }


    public function logout(): Response{

        App::authSession()->end();

        return new Redirect("/", 302);

    }

}