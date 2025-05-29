<?php

namespace app\middlewares;

use app\contracts\MiddlewareContract;

use app\services\Response;

class SessionMiddleware implements MiddlewareContract{
    
    public function handle(mixed $data = null): Response | null{

        if(session_status() === PHP_SESSION_NONE) {
            session_start();
            session_regenerate_id(true);
            return null;        
        };
        
        return null;        

    }

 
}