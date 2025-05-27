<?php
namespace app\middlewares;

use app\classes\CSRFToken;
use app\contracts\MiddlewareContract;
use app\facade\App;
use app\services\Response;

class CSRFMiddleware implements MiddlewareContract{
    
    public function __construct(protected CSRFToken $csrftoken)
    {
        
    }

    public function handle(mixed $data = null): Response | null{

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