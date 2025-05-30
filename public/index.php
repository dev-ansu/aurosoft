<?php


require __DIR__ . "/../bootstrap.php";

use app\classes\ErrorHandler;


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