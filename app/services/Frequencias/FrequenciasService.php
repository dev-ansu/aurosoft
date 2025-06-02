<?php

namespace app\services\frequencias;

use app\core\ServiceResponse;
use app\core\Model;
use PDOException;

class FrequenciasService extends Model{

    protected string $table = 'frequencias';
    protected array $columns = ['id', 'frequencia', 'dias'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function fetchAll(): ServiceResponse
    {
        $all = $this->all();
        return ServiceResponse::success('ok', $all);
    }

    public function insert(array $data){
        $this->columns = ['frequencia', 'dias'];
        
        $find = $this->find('frequencia', $data['nome_frequencia']);

        if($find) return ServiceResponse::error("Esta frequência já existe.", null, 401);

        $insert = $this->create([
            'frequencia' => $data['nome_frequencia'],
            'dias' => $data['dias'],
        ]);

        if($insert) return ServiceResponse::success('Frequência cadastrada com sucesso.', null, 200);

        return ServiceResponse::error("Ocorreu um erro ao cadastrar a frequência", null, 500);

    }

    public function trash($key, $value): ServiceResponse{

        try{

            $find = $this->find($key, $value);
            
            if(!$find) return ServiceResponse::error("Frequência não encotrada.", null);
            
            $response = $this->delete($key, $value);
            
            if($response) return ServiceResponse::success("Frequência excluída com sucesso.", null);
            
            return ServiceResponse::error("A frequência não foi excluída.", null, 500);
        }catch(PDOException $e){
            if($e instanceof PDOException){
                return ServiceResponse::error("Erro de integridade. Não foi é possível excluir a frequência.", null, 500);
            }
        }
        
        return ServiceResponse::error("Frequência não foi excluída.", null, 500);

    }

    public function patch($data): ServiceResponse{
        $body = [
            'id' => $data['id_frequencia'],
            'frequencia' => $data['nome_frequencia'],
            'dias' => $data['dias']
        ];

        $key = 'id';

        $find = $this->find($key, $body['id']);

        if(!$find){
            return ServiceResponse::error("Frequência não encontrada.", null, 409);
        }

        $updated = $this->update($key, $body); 

        if($updated){
            return ServiceResponse::success("Frequência atualizada com sucesso.", null, 201);
        }
      
        return ServiceResponse::error("Frequência não foi atualizada.", null, 500);
        
    }

}
