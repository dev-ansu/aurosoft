<?php
namespace app\services;


class Response{

    public function __construct(
        private $body, 
        private int $statusCode = 200, 
        private array $headers = [])
    {
        
    }
    
    public function send(){
        
        http_response_code($this->statusCode);

        $this->setHeaders();

        echo $this->body;
        
    }  

    private function setHeaders(){
        
        if(!empty($this->headers)){
            foreach($this->headers as $index => $header){
                header("$index:$header");
            }    
        }

    }

}