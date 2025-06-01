<?php
namespace app\contracts;


interface ResponseContract{

    public function json(array $data, array $headers = [], int $status = 200): void;

    public function send($body, array $headers = [], int $status = 200): void;

    public function view($viewName, $viewData, int $status = 200): void;

    public function redirect(string $uri, int $status = 200):void;

    public function setHeaders($headers): void;

}