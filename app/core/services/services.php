<?php
namespace app\core\services;


use app\classes\Session;
use app\core\Controller;
use function DI\autowire;
use app\contracts\SessionContract;
use app\contracts\ResponseContract;
use app\services\PermissionService;
use app\contracts\AuthSessionService;
use app\contracts\ControllerContract;
use app\services\AuthSessionService as ServicesAuthSessionService;
use app\core\Request;
use app\core\Response;

return [
    SessionContract::class => autowire(Session::class),
    AuthSessionService::class => autowire(ServicesAuthSessionService::class),
    PermissionService::class => autowire(PermissionService::class),
    ResponseContract::class => autowire(Response::class),
    ControllerContract::class => autowire(Controller::class),
    Request::class => Request::create(),    
];