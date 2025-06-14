<?php
namespace app\core;

use app\contracts\ResponseContract;




class Response implements ResponseContract{

    public function __construct(private Controller $controller)
    {
        
    }


    public function json(array $data, array $headers = [], int $status = 200): void{
        
        http_response_code($status);
       
        $this->setHeaders($headers);

        echo json_encode($data);

        return;
        
    }

    public function send($body, array $headers = [], int $status = 200): void{
        
        http_response_code($status);

        $this->setHeaders($headers);

        echo $body;

        return;
        
    }  

    public function view($viewName, $viewData, int $status = 200): void{

        http_response_code($status);
        
        (new Controller)->load($viewName, $viewData);

        return;
    }

    public function redirect(string $uri, int $status = 200):void{
        http_response_code($status);
        header("Location: " . $uri);
        exit;
    }    

    public function setHeaders($headers): void{
        
        if(!empty($headers)){
            foreach($headers as $index => $header){
                header("$index: $header");
            }    
        }

    }

}