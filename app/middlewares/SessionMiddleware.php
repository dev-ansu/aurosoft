<?php

namespace app\middlewares;

use app\contracts\MiddlewareContract;
use app\core\Request;
use app\core\Response;

class SessionMiddleware{
    
    public function handle(){

        if(session_status() === PHP_SESSION_NONE) {
            session_start();
            return null;        
        };
        
        return null;        

    }

 
}