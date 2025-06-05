<?php

namespace app\services\FormasPagamento;

use app\core\ServiceResponse;
use app\core\Model;
use PDOException;

class FormasPagamentoService extends Model{

    protected string $table = 'formas_pagamento';
    protected array $columns = ['id', 'nome', 'taxa'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function fetchAll(): ServiceResponse
    {
        $all = $this->all();
        
        return ServiceResponse::success('', $all);
    }


    public function insert(array $data){
        $this->columns = ['nome', 'taxa'];
        $find = $this->find('nome', $data['nome_forma_pagamento']);

        if($find) return ServiceResponse::error("Esta forma de pagamento já existe.", null, 401);

        $insert = $this->create([
            'nome' => $data['nome_forma_pagamento'],
            'taxa' => $data['taxa'] ?? 0.00,
        ]);

        if($insert) return ServiceResponse::success('Forma de pagamento cadastrada com sucesso.', null, 200);

        return ServiceResponse::error("Ocorreu um erro ao cadastrar a forma de pagamento", null, 500);

    }

    public function trash($key, $value): ServiceResponse{

        try{

            $find = $this->find($key, $value);
            
            if(!$find) return ServiceResponse::error("Forma de pagamento não encotrada.", null);
            
            $response = $this->delete($key, $value);
            
            if($response) return ServiceResponse::success("Forma de pagamento excluída com sucesso.", null);
            
            return ServiceResponse::error("A forma de pagamento não foi excluída.", null, 500);
        }catch(PDOException $e){
            if($e instanceof PDOException){
                return ServiceResponse::error("Erro de integridade. Não foi é possível excluir a forma de pagamento.", null, 500);
            }
        }
        
        return ServiceResponse::error("Forma de pagamento não foi excluída.", null, 500);

    }

    public function patch($data): ServiceResponse{
        $body = [
            'id' => $data['id_forma_pagamento'],
            'nome' => $data['nome_forma_pagamento'],
            'taxa' => $data['taxa'] ?? 0.00
        ];

        $key = 'id';

        $find = $this->find($key, $body['id']);

        if(!$find){
            return ServiceResponse::error("Forma de pagamento não encontrada.", null, 409);
        }

        $updated = $this->update($key, $body); 

        if($updated){
            return ServiceResponse::success("Forma de pagamento atualizada com sucesso.", null, 201);
        }
      
        return ServiceResponse::error("Forma de pagamento não foi atualizada.", null, 500);
        
    }

}
