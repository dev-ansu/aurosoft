<?php
namespace app\middlewares;

use app\core\Request;
use app\core\Response;
use app\classes\CSRFToken;


class CSRFMiddleware{
    
    public function __construct(protected CSRFToken $csrftoken)
    {
        
    }

    public function handle(Request $req, Response $res){

        if(!$req->isPost()){
            return null;
        }

        $token = $req->input($this->csrftoken->getTokenName());
        
        if(!$token || !$this->csrftoken->validateToken($token)){
            if($req->isAjax()){
                $res->send("CSRF Token inválido", [], 403);
                exit;
            }

            setFlash("message", "CSRF Token inválido.");
            $res->redirect($req->getServer('HTTP_REFERER') || '/');
            exit;
        }

        
        return null;
    }

 
}