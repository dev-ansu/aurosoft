<?php

namespace app\controllers;

use app\core\Controller;
use app\services\Response;

class TesteController extends Controller{

    public function index(): Response{
        return new Response(
            'Hello world!'
        );
    }

}
