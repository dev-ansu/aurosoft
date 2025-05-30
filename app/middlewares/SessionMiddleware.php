<?php

namespace app\middlewares;

use app\contracts\MiddlewareContract;
use app\services\Request;
use app\services\Response;

class SessionMiddleware{
    
    public function handle(){

        if(session_status() === PHP_SESSION_NONE) {
            session_start();
            return null;        
        };
        
        return null;        

    }

 
}