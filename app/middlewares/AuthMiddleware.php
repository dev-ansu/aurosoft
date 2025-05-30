<?php
namespace app\middlewares;

use app\core\Request;
use app\core\Response;
use app\classes\Session;

class AuthMiddleware{

    public function __construct(private Session $session)
    {
        
    }

    public function handle(Request $req, Response $res){
        // Verifica se a sessão possui o índice SESSION_LOGIN
        $sessionHas = $this->session->has(SESSION_LOGIN);
        $sessionEmpty = empty($this->session->__get(SESSION_LOGIN));
       
        if(!$sessionHas || $sessionEmpty){
            if($req->isAjax()){
                return $res->send('Não autorizado',[],403);
            }else{
                setFlash('message', 'Não autorizado');
                $res->redirect("/");
                return;
            }

        } 
        return null;
    }

}