<?php
namespace app\contracts;

use app\services\Request;
use app\services\Response;

interface MiddlewareContract{

    public function handle(?Request $req, ?Response $res);

}