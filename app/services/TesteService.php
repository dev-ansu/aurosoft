<?php

namespace app\services;

use app\core\ServiceResponse;
use app\core\Model;

class TesteController extends Model{

    protected string $table = '';
    protected array $columns = [];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function fetchAll(): ServiceResponse
    {
        return ServiceResponse::success('ok', $this->all());
    }

}
