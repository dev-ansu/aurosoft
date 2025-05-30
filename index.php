<?php


require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/config.php";

use app\core\Core;
use app\classes\ErrorHandler;
use app\core\Container;
use app\core\Router;
use app\facade\App;
use app\services\Request;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ );
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

try{

    $core->run();

}catch(\Exception $e){

    ErrorHandler::log($e); 
    http_response_code(500);
    echo $e->getLine();
    echo $e->getMessage();


}catch(\Throwable $e){
    ErrorHandler::log($e);
    ErrorHandler::handleException($e);
    http_response_code(500);

}



// Faça o resto da sua execução PHP abaixo