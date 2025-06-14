<?php
namespace app\contracts;

use app\core\Request;
use app\core\Response;

interface MiddlewareContract{

    public function handle(Request $req, Response $res);

}