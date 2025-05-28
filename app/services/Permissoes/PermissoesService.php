<?php

namespace app\services\permissoes;

use app\core\ServiceResponse;
use app\core\Model;

class PermissoesService extends Model{

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
