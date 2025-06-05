<?php

use app\classes\Session;
use app\core\Router;
use app\facade\App;

/** Carrega um recurso
 * @param string $resource - recurso a ser carregado
 * @return string
 */
function asset(string $resource): string {
    return rtrim(ASSETS_PATH, '/') . '/' . ltrim($resource, '/');
}

/** Carrega um componente na view
 * @param string $componentName - o nome do component a ser carregado
 * @param array $componentData - o dados a serem impressos no componente
 */
function component(string $componentName, array $componentData = []): void{
    $name = escape($componentName);

    if(str_contains($name, ".")){
        $name = str_replace(".", DIRECTORY_SEPARATOR, $name);
    }

    $file = COMPONENTS_PATH . "{$name}.php";
  
    if(file_exists($file)){
        extract($componentData);
        include $file;        
    }

}

function setOld(string $key, mixed $value): void{
    $key = $key . ".old";
    $session = App::session();
       
    if(empty($session->get($key))){
        $key = escape($key);
        $value = escape($value);
   
        $session->__set($key, $value);
    }
    

}

function getOld(string $key){
  
    $session = App::session();

    
    if($session->has($key) || !empty($session->get($key))){
        $key = escape($key);

        $old = $session->__get($key);

        $session->unset($key);

        return $old;
    }

    return null;
}

/**
 * Define uma flash message
 * @param string $key - a chave da flash message
 * @param string $message - a mensagem da flash message
 * @param string $type (danger | primary | success | warning) - o tipo da flash message
 * @return void
 */
function setFlash(string $key, string $message, string $type = "danger"){

    if(empty($_SESSION[$key])){

        $_SESSION[$key] = [
            'message' => $message,
            'type' => $type,
            'id' => 'css'.md5($key . $message . $type . time()),
        ];

    }
}

/**
 * Pega uma flash message
 * @param string $key - a chave da flash message
 * @return void
 */



function getFlash($key, $onlyText = false){

    if(!empty($_SESSION[$key])){

        $flash = $_SESSION[$key];

        unset($_SESSION[$key]);

        $message = $flash['message'];
        $type = $flash['type'];
        $id = $flash['id'];

        $message = htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8');
        $type = htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8');
        $id = htmlspecialchars($flash['id'], ENT_QUOTES, 'UTF-8');
        
        // Controle separado de carregamento
        static $basicAssetsLoaded = false;
        static $fullCssLoaded = false;

        $styles = '';
        $scripts = '';

        // Sempre carrega o básico na primeira execução
        if (!$basicAssetsLoaded) {
            $basicAssetsLoaded = true;

            $styles .= <<<STYLE
                <style>
                    .my-alert {
                        width: auto;
                        height: auto;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        font-family: sans-serif;
                    }

                    .btn-close-alert::before {
                        content: "X";
                    }

                    .btn-close-alert {
                        display: block;
                        cursor: pointer;
                        background-color: transparent;
                        outline: none;
                        border: 1px solid transparent;
                    }
                </style>
            STYLE;

            $scripts .= <<<SCRIPT
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        document.querySelectorAll('.btn-close-alert').forEach(function (btn) {
                            btn.addEventListener('click', function (e) {
                                let alertClicked = document.getElementById(e.target.parentNode.id);
                                alertClicked.remove();
                            });
                        });
                    });
                </script>
            SCRIPT;
        }
      

         // Carrega o CSS completo só uma vez e somente se !onlyText
        if (!$onlyText && !$fullCssLoaded) {
            $fullCssLoaded = true;

            $styles .= <<<STYLE
                <style>
                   .$id.my-alert{
                        padding: 15px 10px;
                        border-radius: 10px;
                        font-size: 16px;
                        margin-bottom: 10px;
                    }

                   .$id.my-alert.my-alert-danger {
                        background: #f8d7da;
                        color: #7f4159;
                    }

                   .$id.my-alert.my-alert-success {
                        background: #d4ecdb;
                        color: #32643c;
                    }

                   .$id.my-alert.my-alert-primary {
                        background: #cde5fe;
                        color: #8f6941;
                    }

                    .$id.my-alert.my-alert-warning{
                        background: #fef3cc;
                        color: #8f6941;
                    }

                    .$id .btn-close-alert {
                        padding: 5px 10px;
                        border-radius: 4px;
                        transition: all 0.4s ease;
                    }

                    .$id .btn-close-alert:hover {
                        background: #ccc;
                    }
                </style>
            STYLE;
        }


        $html = <<<HTML
                {$styles}
                <span id="$id" class="my-alert my-alert-{$type} {$id}">
                    <span>{$message}</span>
                    <span class="btn-close-alert"></span>
                </span>
                {$scripts}
        HTML;

        return $html;
    }

}

/**
 * Redireciona o usuário para um link interno do site
 * @param string $to - url de destino
 * @return void
 */
function redirect(string | null $to = null): void{
    header("location: " . BASE_URL . $to);
    die;
}


/**
 * Define uma rota a ser seguida
 * @param string $route
 */
function route(string $route = "/"){
    if(str_contains($route, ".")){
        $route = str_replace(".", "/", $route);
    }
    return BASE_URL . $route;
}

/**
 * Função para escapar dados
 * @param string $value
 * @return mixed
 */
function escape($value){
    return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8'):$value;
}

function uploaded(string $resource){
    return rtrim(UPLOADS_PATH, '/') . '/' . ltrim($resource, '/');
}