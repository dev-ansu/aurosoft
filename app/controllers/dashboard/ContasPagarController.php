<?php

namespace app\controllers\dashboard;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class ContasPagarController{

    public function index(Request $req, Response $res){
        return $res->send('Hello, World!');
    }

}
