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
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute();

        return ServiceResponse::success('ok', $query->fetchAll());
    }
    public function fetchAllAbertas(): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia WHERE vencimento >= DATE(NOW()) AND (pago = 0 OR pago IS NULL) ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute();

        return ServiceResponse::success('ok', $query->fetchAll());
    }
    public function fetchAllAtrasadas(): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia WHERE vencimento < DATE(NOW()) AND (pago = 0 OR pago IS NULL) ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute();

        return ServiceResponse::success('ok', $query->fetchAll());
    }
    public function fetchAllConfirmadas(): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia WHERE (pago = 1 AND pago IS NOT NULL) ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute();

        return ServiceResponse::success('ok', $query->fetchAll());
    }

    public function fetchBetween($data_ini, $data_fim): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia
            WHERE vencimento BETWEEN :data_ini AND :data_fim ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute([
            'data_ini' => $data_ini,
            'data_fim' => $data_fim
        ]);

        return ServiceResponse::success('ok', $query->fetchAll());
    }
    public function fetchAtrasadas($data_ini, $data_fim, $today): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia
            WHERE (vencimento BETWEEN :data_ini AND :data_fim AND vencimento < :today) AND (pago IS NULL || pago = 0) ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute([
            'today' => $today,
            'data_ini' => $data_ini,
            'data_fim' => $data_fim
        ]);

        return ServiceResponse::success('ok', $query->fetchAll());
    }
    public function fetchAbertas($data_ini, $data_fim, $today): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia
            WHERE (vencimento BETWEEN :data_ini AND :data_fim AND vencimento >= :today) AND (pago IS NULL || pago = 0) ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute([
            'today' => $today,
            'data_ini' => $data_ini,
            'data_fim' => $data_fim
        ]);

        return ServiceResponse::success('ok', $query->fetchAll());
    }
    public function fetchConfirmadas($data_ini, $data_fim): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia
            WHERE (vencimento BETWEEN :data_ini AND :data_fim) AND pago = 1 ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute([
            'data_ini' => $data_ini,
            'data_fim' => $data_fim
        ]);

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

        if($find->arquivo && file_exists(UPLOAD_DIR . $find->arquivo)){
            unlink(UPLOAD_DIR . $find->arquivo);
        }

        $delete = $this->delete('id', $id);

        if($delete) return ServiceResponse::success("O recebimento foi excluído com sucesso.", null);

        return ServiceResponse::error("Não foi possível excluir o recebimento.", null);

    }

    public function patch($data){
        $find = $this->find('id', $data['id']);

        if(!$find) return ServiceResponse::error("Conta não encontrada.", null);

        if($find && $find->pago != null) return ServiceResponse::error("Não é possível atualizar um recebimento já confirmado.", null);

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

        return ServiceResponse::success('Olá', $data);
    }

}
