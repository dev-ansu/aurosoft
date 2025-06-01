<?php


use app\middlewares\SessionMiddleware;
ini_set('session.cookie_httponly', 1);     // Impede acesso por JavaScript
ini_set('session.use_strict_mode', 1);     // Evita aceitar IDs de sessão inválidos
ini_set('session.use_only_cookies', 1);    // Nunca usa ID de sessão pela URL

// Reforce a segurança dos cookies de sessão
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Em produção, adicione esta linha (com HTTPS):
// ini_set('session.cookie_secure', 1);

(new SessionMiddleware)->handle();

date_default_timezone_set("America/Sao_Paulo");

define("CONTROLLERS_PATH", dirname(__DIR__) . "\\app\\controllers\\");

define("VIEWS_PATH", __DIR__ . "/../app/views/");

define("COMPONENTS_PATH",  __DIR__ . "/../app/views/components/");
define("UPLOAD_DIR",  __DIR__ . "/../public/uploads/");

define("BASE_URL", 
    (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] === 'on' ? "https://":"http://")
    . $_SERVER['HTTP_HOST'] .
    rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']),"/")
);


define("ASSETS_PATH", BASE_URL . "/assets");
define("UPLOADS_PATH", BASE_URL . "/uploads");
define("SESSION_LOGIN", "logado");



