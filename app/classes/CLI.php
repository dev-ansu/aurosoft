<?php
namespace app\classes;


class CLI{

    public function init(mixed $argv){
        $commands = $argv;

        array_shift($commands);

        if(count($commands) < 2){
            echo "Uso: php maker make:[controller, model, etc] Nome/do/objeto";
            exit;
        }

        $action = $commands[0]; // objeto a ser criado;
        $action = explode(":", $action);
        $actionName = $action[1];
        $afterTwoDot = ucfirst($actionName);
        $method = $action[0].$afterTwoDot;

        if(!method_exists($this, $method)){
            echo $method;
            echo "Este método não existe! Exemplos de objetos que podem ser criados:\n
            - make:controller;
            - make:model;
            - make:middleware.
            ";
            exit;
        }

        $nameInput = $commands[1]; // exemplo Usuairos/Usuarios

        $parts = explode("/", $nameInput);
        $className = array_pop($parts); // pegar o último arquivo (que será o .php)

        $subPath = implode("/", $parts); //subpastas, se houver
        $folder = "app/{$actionName}s/" . $subPath;
        $path = "{$folder}/{$className}{$afterTwoDot}.php";
  
        $namespace = $subPath ? str_replace('/','\\', $folder): rtrim(str_replace("/", "\\", $folder), "\\");
     
        $classFullName = $className . "Controller";

        $this->createFile($path, call_user_func_array([$this, $method], [$classFullName, $namespace]));

    }

    private function makeController($classFullName, $namespace){
        return <<<PHP
        <?php

        namespace {$namespace};

        use app\core\Controller;
        use app\services\Response;

        class $classFullName extends Controller{

            public function index(): Response{
                return new Response(
                    'Hello world!'
                );
            }

        }

        PHP;

    }   
    
    private function makeService($classFullName, $namespace){
        return <<<PHP
        <?php

        namespace {$namespace};

        use app\core\ServiceResponse;
        use app\core\Model;

        class $classFullName extends Model{

            protected string \$table = '';
            protected array \$columns = [];

            public function __construct(string | null \$env = '')
            {
                \$this->name = \$env;
            }

            public function fetchAll(): ServiceResponse
            {
                return ServiceResponse::success('ok', \$this->all());
            }

        }

        PHP;

    }    

    private function createFile($path, $content){

        $dir = dirname($path);

        if(!is_dir($dir)){
            mkdir($dir, 0777, true);
        }

        file_put_contents($path,  $content);

        if(file_exists($path)){
            echo "Arquivo de Controller criado com sucesso.";
            exit;
        }

        echo "Arquivo de Controller não foi criado.";
        exit;

    }
}