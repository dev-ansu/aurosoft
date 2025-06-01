<?php

namespace app\services\acessos;

use app\core\ServiceResponse;
use app\core\Model;
use app\services\GrupoAcessos\GrupoAcessosService;

class AcessosService extends Model{

    protected string $table = 'acessos';
    protected array $columns = ['id', 'nome', 'chave', 'grupo_id', 'pagina'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function insert($data): ServiceResponse{

        // $find = $this->find('nome', $data['nome_acesso']);

        $findGrupo = null;

        if(!empty($data['grupo_id'])){
            $findGrupo = (new GrupoAcessosService())->find('id', $data['grupo_id']);
            if(!$findGrupo) return ServiceResponse::error("Este grupo de acesso não existe."); 
        }

        
        // if($find) return ServiceResponse::error("Este nome de acesso já existe.");

        // if($find) return ServiceResponse::error("Este grupo de acesso já existe.");
        

        $body = [
            'nome' => $data['nome_acesso'],
            'chave' => strtolower($data['chave']),
            'grupo_id' => $findGrupo->id ?? $data['grupo_id'],
            'pagina' => $data['pagina']
        ];

        $created = $this->create($body);        

        if(!$created) return ServiceResponse::error("Não foi possível criar o acesso.", null); 

        return ServiceResponse::success("Acesso criado com sucesso.", null, 201);

    }

    public function acessoByGrupo($grupo_id){
        $find = $this->find('grupo_id', $grupo_id);
        $sql = "SELECT * FROM acessos WHERE grupo_id = :grupo_id";
        $prepare = $this->connection()->prepare($sql);
        $prepare->execute([
            'grupo_id' => $grupo_id,
        ]);
        $acessosByGrupo = $prepare->fetchAll();
        return ServiceResponse::success('ok', $acessosByGrupo);
    }

    public function fetchAll(): ServiceResponse
    {   
        $columns = implode(",", array_map(fn($column) => $this->table . "." . $column, $this->columns));
        
        $sql = "SELECT {$columns}, ga.nome as nome_grupo, pagina FROM {$this->table} LEFT JOIN grupo_acessos ga ON ga.id = {$this->table}.grupo_id";

        $prepare = $this->connection()->prepare($sql);

        $exec = $prepare->execute();

        return ServiceResponse::success('ok', $prepare->fetchAll());
    }

    public function trash($key, $value): ServiceResponse{
        $find = $this->find($key, $value);
        
        if(!$find) return ServiceResponse::error("Acesso não encontrado.", null);

        $response = $this->delete($key, $value);

        if($response) return ServiceResponse::success("Acesso excluído com sucesso.", null);

        return ServiceResponse::error("O acesso não foi excluído.", null, 500);

    }

    public function patch($data): ServiceResponse{

        $body = [
            'id' => $data['acesso_id'],
            'grupo_id' => $data['grupo_id'],
            'nome' => $data['nome_acesso'],
            'chave' => $data['chave'],
            'pagina' => $data['pagina']
        ];

        $key = 'id';

        $find = $this->find($key, $body['id']);

        if(!$find){
            return ServiceResponse::error("Acesso não encontradas.", null, 409);
        }

        $updated = $this->update($key, $body); 

        if($updated){
            return ServiceResponse::success("Acesso atualizadas com sucesso.", null, 201);
        }
      
        return ServiceResponse::error("Acesso não foram atualizadas.", null, 500);
        
    }

}
