<?php

namespace app\controllers;

use app\core\Controller;
use app\database\QueryBuilder;
use app\services\Response;

class TesteController extends Controller{

    public function index(){
        $query = new QueryBuilder();
        $query->table('usuarios');
    }

}
