<?php

namespace app\controllers;

use app\facade\App;
use app\core\Request;
use app\core\Response;
use app\classes\Session;
use app\requests\LoginRequest;
use app\services\Auth\AuthService;
use app\services\Config\ConfigService;
use app\services\permissoes\PermissoesService;


class LoginController{

    public function __construct(
        protected AuthService $auth,
        private ConfigService $config
    )
    {
    }
    
    public function index(Request $request, Response $res) {

            $validate = $request->post()->validate(LoginRequest::class);
                                
            if($validate['error'] === true){
                setFlash('message', 'Verifique os campos e tente novamente.');
                $res->redirect("/");
            }
            
            $data = $validate['issues'];

            $user = $this->auth->execute($data);

            if(!$user){
                setFlash('message', 'E-mail ou senha incorreto');
                $res->redirect('/');
                exit;
            }

            if(strtolower($user->ativo) !== "sim"){
                setFlash('message', 'O seu acesso está bloqueado, pois o seu perfil não está ativo.');
                $res->redirect('/');
                exit;
            }

            session_regenerate_id(true);

            
            $permissoes = (new PermissoesService())->fetchUsuarioPermissoesByUsuarioWithChave($user->id)->toArray()['data'];

            
            $user->permissoes = $permissoes;

            $gruposPermissao = [];

            foreach($user->permissoes as $permissao){
                $nome_grupo = $permissao->grupo_id ? $permissao->nome_grupo:'sem_grupo';
                $gruposPermissao[$nome_grupo][] = $permissao;
            }
            
            $config = (new ConfigService())->fetch();
            
            App::session()->__set('config', $config);
            
            $user->permissoesPorGrupo = $gruposPermissao;
            
            App::authSession()->init($user);

            $pagina = '/dashboard';

            if($user->nivel !== "Administrador"){
                foreach($permissoes as $permissao){
                    
                    if($permissao->pagina === "Sim"){
                        $pagina = "/".$permissao->chave;
                        break;
                    }
                }
            }
            
                 
            return $res->redirect($pagina);
        
    }


    public function logout(Request $req, Response $res){

        App::authSession()->end();
        
        Session::remove();
        
        return $res->redirect("/");

    }

}