<?php
namespace app\core;


class ServiceResponse{

    public function __construct(public bool $error, public string $message, public mixed $data = null, public int $code = 200)
    {
        
    }

    public static function success(string $message, mixed $data = null, int $code = 200):self{
        return new self(false, $message, $data, $code);
    }

    public static function error(string $message, mixed $data = null, int $code = 400):self{
        return new self(true, $message, $data, $code);
    }

    
    public function toArray(): array{
        return [
            'error' => $this->error,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}