<?php
namespace app\middlewares;

use app\classes\Session;
use app\contracts\MiddlewareContract;
use app\services\Redirect;
use app\services\Request;
use app\services\Response;

class AuthMiddleware{

    public function __construct(private Session $session, private Request $request)
    {
        
    }

    public function handle(Request $req, Response $res){
        // Verifica se a sessão possui o índice SESSION_LOGIN
        $sessionHas = $this->session->has(SESSION_LOGIN);
        $sessionEmpty = empty($this->session->__get(SESSION_LOGIN));
       
        if(!$sessionHas || $sessionEmpty){
            if($this->request->isAjax()){
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