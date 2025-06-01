<?php
namespace app\controllers;

use app\core\Request;
use app\core\Response;


class NotFoundHandler{
    
    public function handle(Request $req, Response $res){
        http_response_code(404);
        header("Content-Type: text/html"); 

        $viewData = [
            'title' => 'Página não encontrada',
            'message' => 'A URL solicitada não existe.',
        ];
        
        extract($viewData);
        if(file_exists(VIEWS_PATH . "/not-found.php")){
            return $res->view('not-found', $viewData);
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

            return $res->send('not-found', $viewData);
        }
    }
}