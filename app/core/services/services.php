<?php

use app\classes\Session;
use app\contracts\SessionContract;
use app\contracts\AuthSessionService;
use app\contracts\ControllerContract;
use app\contracts\ResponseContract;
use app\core\Controller;
use app\services\AuthSessionService as ServicesAuthSessionService;
use app\services\PermissionService;
use app\services\Request;
use app\services\Response;

use function DI\autowire;


return [
    SessionContract::class => autowire(Session::class),
    AuthSessionService::class => autowire(ServicesAuthSessionService::class),
    PermissionService::class => autowire(PermissionService::class),
    ResponseContract::class => autowire(Response::class),
    ControllerContract::class => autowire(Controller::class),
    Request::class => Request::create(),    
];