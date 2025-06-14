<?php
namespace app\core;

use app\classes\InputData;
use app\contracts\RequestContract;

class Request implements RequestContract{
    
    public function __construct(
        protected array $server,
        protected array $post,
        protected array $get,
        protected array $session,
        protected array $files
    )
    {
        
    }

    public static function create(): static{
        return new static(
            $_SERVER,
            $_POST,
            $_GET,
            $_SESSION,
            $_FILES
        );
    }

    public function get(): InputData{
        return new InputData($this->get);
    }

    public function post(): InputData{
        return new InputData($this->post);
    }
    
    public function file(string $key): InputData{
        return new InputData($this->files[$key]);
    }

    public function files(string $key): InputData{
        return new InputData($this->files);
    }

    public function getQuery(string $key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }
    

    public function getPost(string $key, $default = null){
        return $this->post[$key] ?? $default;
    }

    public function getServer(string $key, $default = null){
        return $this->server[$key] ?? $default;
    }

    public function getSession(string $key, $default = null){
        return $this->session[$key] ?? $default;
    }

    public function isGet():bool{
        return $this->server['REQUEST_METHOD'] === "GET";
    }

    public function isPost():bool{
        return $this->server['REQUEST_METHOD'] === "POST";
    }

    public function isAjax(): bool{
        return !empty($this->server['HTTP_X_REQUESTED_WITH']) &&
        strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function json(): ?InputData
    {
        $data = $this->getJsonBody();
        return $data ? new InputData($data) : null;
    }

    public function getJsonBody(): ?array{
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        return is_array($data) ? $data : null;
    }

    public function input(string $key, $default = null){

        if(isset($this->post[$key])){
            return $this->post[$key];
        }

        if(isset($this->get[$key])){
            return $this->get[$key];
        }

        $json = $this->getJsonBody();
        if($json && isset($json[$key])){
            return $json[$key];
        }

        return $default;
    }


}