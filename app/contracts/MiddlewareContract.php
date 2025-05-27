<?php
namespace app\contracts;

use app\services\Response;

interface MiddlewareContract{

    public function handle(mixed $data = null): ?Response;

}