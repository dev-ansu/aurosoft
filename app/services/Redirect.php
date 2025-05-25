<?php
namespace app\services;

class Redirect extends Response{

    public function __construct(string $url, int $statusCode = 302)
    {
        parent::__construct('', $statusCode, [
            'Location' => $url,
        ]);
    }
}