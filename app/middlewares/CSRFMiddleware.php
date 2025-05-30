<?php
namespace app\middlewares;

use app\classes\CSRFToken;
use app\contracts\MiddlewareContract;
use app\facade\App;
use app\services\Request;
use app\services\Response;

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
                return;
            }
        }

        
        return null;
    }

 
}