<?php

namespace app\controllers\api;

use app\core\Controller;
use app\services\Response;

class PermissoesController extends Controller{

    public function index(): Response{
        
        return new Response(
            'Hello world!'
        );
    }

}
