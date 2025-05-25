<?php 
namespace app\classes;

use app\facade\App;
use app\services\Response;

class DeniedAcess extends Response{
    public function __construct($message, string $url = '/', $statusCode = 403)
    {
        if(App::request()->isAjax()){
            return new Response(
                escape($message),
                $statusCode
            );
        }

        setFlash('message',  escape($message));

        parent::__construct('', $statusCode, 
            [
                'Location' => $url,
            ]
        );
    }
}