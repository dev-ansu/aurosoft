<?php

namespace app\services\contasreceber;

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
    ];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function fetchAll(): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.* FROM {$this->table} 
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

}
