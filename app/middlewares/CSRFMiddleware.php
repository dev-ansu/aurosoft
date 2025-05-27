<?php
namespace app\middlewares;

use app\classes\CSRFToken;
use app\classes\DeniedAcess;
use app\contracts\CSRFMiddlewareContract;
use app\facade\App;
use app\services\Redirect;
use app\services\Response;

class CSRFMiddleware implements CSRFMiddlewareContract{
    
    public function __construct(protected CSRFToken $csrftoken)
    {
        
    }

    public function handle(): ?Response{

        if(!App::request()->isPost()){
            return null;
        }

        $token = App::request()->input($this->csrftoken->getTokenName());
        
        if(!$token || !$this->csrftoken->validateToken($token)){
            return new Response('CSRF token inválido.', 403);
        }

        
        return null;
    }

 
}