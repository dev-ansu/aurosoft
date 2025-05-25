<?php
namespace app\controllers;

use app\core\Controller;
use app\services\Response;

class NotFoundHandler extends Controller{
    
    public function handle(): Response{
        http_response_code(404);
        header("Content-Type: text/html"); 

        $viewData = [
            'title' => 'Página não encontrada',
            'message' => 'A URL solicitada não existe.',
        ];
        
        extract($viewData);
        if(file_exists(VIEWS_PATH . "/not-found.php")){
            return new Response(
                $this->load('not-found', $viewData),
                404,
            );
        }else{
            $html = <<<HTML
                <style>
                    *{
                        padding:0;
                        margin:0;
                        font-family:"sans-serif";
                    }
                    div{
                        background: #0e172a;
                        color: #fff;
                        height: 100vh;
                        display:flex;
                        justify-content:center;
                        align-items:center;
                    }
                    h1{
                        font-family: ui-sans-serif, system-ui, sans-serif;
                        font-size: 20px;
                        font-weight: 100;
                    }
                </style>
                <div>
                    <h1>404 | PÁGINA NÃO ENCONTRADA</h1>
                </div>
            HTML;

            return new Response($html, 404);
        }
    }
}