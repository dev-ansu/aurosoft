<?php

namespace app\services\ContasReceber;

use app\core\ServiceResponse;
use app\core\Model;

class ContasReceberService extends Model{

    protected string $table = 'contas_receber';
    protected array $columns = [
        'id',
        'descricao',
        'cliente',
        'valor',
        'vencimento',
        'data_pgto',
        'data_lanc',
        'forma_pgto',
        'forma_pgto',
        'frequencia',
        'arquivo',
        'observacao',
        'referencia',
        'id_ref',
        'multa',
        'juros',
        'desconto',
        'subtotal',
        'usuario_lanc',
        'usuario_pgto',
        'pago',
        'taxa'
    ];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function fetchAll(): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute();

        return ServiceResponse::success('ok', $query->fetchAll());
    }

    public function insert($data): ServiceResponse{
        $this->columns = [
            'descricao',
            'cliente',
            'valor',
            'vencimento',
            'data_pgto',
            'data_lanc',
            'forma_pgto',
            'forma_pgto',
            'frequencia',
            'arquivo',
            'observacao',
            'referencia',
            'subtotal',
            'usuario_lanc',
        ];
        
        $data['subtotal'] = $data['valor'];

        $create = $this->create($data);

        if($create){
            return ServiceResponse::success('Conta cadastrada com sucesso.', $data);
        }

        return ServiceResponse::error("A conta não foi cadastrada.", $data);
        
    }

    public function trash(int $id){
        
        $find = $this->find('id', $id);

        if(!$find) return ServiceResponse::error("Conta não encontrada.", null);

        if($find && $find->pago != null) return ServiceResponse::error("Não é possível excluir um recebimento já confirmado.", null);

        $this->columns = ['id'];

        $delete = $this->delete('id', $id);

        if($delete) return ServiceResponse::success("O recebimento foi excluído com sucesso.", null);

        return ServiceResponse::error("Não foi possível excluir o recebimento.", null);

    }

}
