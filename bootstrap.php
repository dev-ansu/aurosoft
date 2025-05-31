<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/config.php";

use app\core\Core;
use app\facade\App;
use app\core\Router;
use app\core\Container;
use app\core\Request;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$cachePath = __DIR__ ."/src/cache/routes.php";
$shouldRebuild = $_ENV['APP_ENV'] === 'dev';

if(!file_exists($cachePath) || $shouldRebuild){
    // Carrega rotas do cache
    require_once __DIR__ . "/src/routes/web.php";
    require_once __DIR__ . "/src/routes/api.php";
    Router::cache($cachePath);
}else{
    Router::loadFromCache($cachePath);
}
$services = __DIR__ . "/app/core/services/services.php";
// $builder = new ContainerBuilder();
// $builder->addDefinitions($services);
// $container = $builder->build();
$request = Request::create();

$container = new Container();

$container = $container->build(['services']);

App::setContainer($container);


$core = new Core($container);



