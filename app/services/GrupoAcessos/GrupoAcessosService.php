<?php

namespace app\services\GrupoAcessos;

use app\core\DBManager;
use app\core\Model;
use app\core\ServiceResponse;
use Cake\Core\ServiceConfig;

class GrupoAcessosService extends Model{
    
    protected string $table = 'grupo_acessos';
    protected array $columns = ['id', 'nome'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }


    public function fetchAll(): ServiceResponse{
 
        $grupoAcessos = $this->all();

        return ServiceResponse::success('', $grupoAcessos);
    }

    public function trash($key, $value): ServiceResponse{
        $find = $this->find($key, $value);
        
        if(!$find) return ServiceResponse::error("Grupo de acesso não encontrado.", null);

        $response = $this->delete($key, $value);

        if($response) return ServiceResponse::success("Grupo de acesso excluído com sucesso.", null);

        return ServiceResponse::error("O grupo de acesso não foi excluído.", null, 500);

    }



}