<?php 
namespace app\classes;

use app\facade\App;
use app\services\Response;

class DeniedAcess extends Response{
    public function __construct($message, string $url = '/', $statusCode = 403)
    {
        if(App::request()->isAjax()){
            parent::__construct(
                $message,
                $statusCode
            );
            return;
        }

        setFlash('message',  escape($message));

        parent::__construct('', $statusCode, 
            [
                'Location' => BASE_URL . $url,
            ]
        );

        return;
    }
}