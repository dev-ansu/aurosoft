<?php

namespace app\services\Cargos;

use app\core\ServiceResponse;
use app\core\Model;
use Exception;
use PDOException;

class CargosService extends Model{

    protected string $table = 'cargos';
    protected array $columns = ['id', 'nome'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function fetchAll(): ServiceResponse
    {   
        $all = $this->all();
        return ServiceResponse::success('ok', $all);
    }

    public function insert($data): ServiceResponse{
        $find = $this->find('nome', $data['nome']);

        if($find) return ServiceResponse::error('Este cargo já existe.', $find);

        try{

            $create = $this->create($data);
        
            if($create){
                return ServiceResponse::success('Cargo criado com sucesso.', $data);
            }
            
            return ServiceResponse::error('Não foi possível criar o cargo.');

        }catch(Exception $e){
            return ServiceResponse::error('Não foi possível criar o cargo, erro: ' . $e->getMessage());
        }
    }

     public function trash($key, $value): ServiceResponse{

        try{

            $find = $this->find($key, $value);
            
            if(!$find) return ServiceResponse::error("Cargo não encotrado.", null);
            
            $response = $this->delete($key, $value);
            
            if($response) return ServiceResponse::success("Cargo excluída com sucesso.", null);
            
            return ServiceResponse::error("A cargo não foi excluído.", null, 500);

        }catch(PDOException $e){
      
            return ServiceResponse::error("Erro de integridade. Não foi é possível excluir o cargo.", null, 500);
      
        }
        
        return ServiceResponse::error("Cargo não foi excluído.", null, 500);

    }

}
