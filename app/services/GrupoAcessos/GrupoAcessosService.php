<?php

namespace app\services\GrupoAcessos;

use app\core\Model;
use app\core\ServiceResponse;
use PDOException;

class GrupoAcessosService extends Model{
    
    protected string $table = 'grupo_acessos';
    protected array $columns = ['id', 'nome'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }


    public function fetchAll(): ServiceResponse{
 
        $sql = "SELECT {$this->table}.*, COUNT(acessos.id) as QtdAcessos FROM {$this->table} LEFT JOIN acessos ON {$this->table}.id = acessos.grupo_id GROUP BY {$this->table}.id";
        
        $prepare = $this->connection()->prepare($sql);
        
        $exec = $prepare->execute();

        $grupoAcessos = $prepare->fetchAll();

        return ServiceResponse::success('', $grupoAcessos);
    }

    public function fetchAllGrupos(){
        $sql = "SELECT {$this->table}.* FROM {$this->table}";
        
        $prepare = $this->connection()->prepare($sql);
        
        $prepare->execute();

        $grupoAcessos = $prepare->fetchAll();

        return ServiceResponse::success('', $grupoAcessos);
    }

    public function insert($data): ServiceResponse{
        $nome_grupo = $data['nome_grupo'];

        $find = $this->find('nome', $nome_grupo);

        if($find) return ServiceResponse::error("Este grupo de acesso já existe.");

        $created = $this->create(['nome' => $nome_grupo]);        

        if(!$created) return ServiceResponse::error("Não foi possível criar o grupo de acesso.", null); 

        return ServiceResponse::success("Grupo de acesso criado com sucesso.", null, 201);

    }

    public function trash($key, $value): ServiceResponse{

        try{

            $find = $this->find($key, $value);
            
            if(!$find) return ServiceResponse::error("Grupo de acesso não encontrado.", null);
            
            $response = $this->delete($key, $value);
            
            if($response) return ServiceResponse::success("Grupo de acesso excluído com sucesso.", null);
            
            return ServiceResponse::error("O grupo de acesso não foi excluído.", null, 500);
        }catch(PDOException $e){
            if($e instanceof PDOException){
                return ServiceResponse::error("Erro de integridade. Não foi é possível excluir um grupo que possui acessos cadastrados.", null, 500);
            }
        }
        
        return ServiceResponse::error("O grupo de acesso não foi excluído.", null, 500);

    }

    public function patch($data): ServiceResponse{
        $this->columns = ['id', 'nome'];
        $body = [
            'id' => $data['grupo_id'],
            'nome' => $data['nome_grupo']
        ];
        $key = 'id';

        $find = $this->find($key, $body['id']);

        if(!$find){
            return ServiceResponse::error("Grupo não encontradas.", null, 409);
        }

        $updated = $this->update($key, $body); 

        if($updated){
            return ServiceResponse::success("Grupo atualizadas com sucesso.", null, 201);
        }
      
        return ServiceResponse::error("Grupo não foram atualizadas.", null, 500);
        
    }



}