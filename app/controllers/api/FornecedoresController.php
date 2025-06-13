<?php

namespace app\controllers\api;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class FornecedoresController{

    public function index(Request $req, Response $res){
        return $res->send('Hello, World!');
    }

}
