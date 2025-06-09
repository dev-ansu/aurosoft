<?php

namespace app\services\ContasReceber;

use app\core\ServiceResponse;
use app\core\Model;
use app\facade\App;
use app\services\Frequencias\FrequenciasService;
use app\services\Usuarios\UsuariosService;
use DateTime;
use Frequencias;

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
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia WHERE deleted_at IS NULL ORDER BY vencimento
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
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia WHERE deleted_at IS NULL AND (pago = 1 AND pago IS NOT NULL) ORDER BY vencimento
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
            WHERE deleted_at IS NULL AND vencimento BETWEEN :data_ini AND :data_fim ORDER BY vencimento
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
            WHERE deleted_at IS NULL AND (vencimento BETWEEN :data_ini AND :data_fim AND vencimento < :today) AND (pago IS NULL || pago = 0) ORDER BY vencimento
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
            WHERE deleted_at IS NULL AND (vencimento BETWEEN :data_ini AND :data_fim AND vencimento >= :today) AND (pago IS NULL || pago = 0) ORDER BY vencimento
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
            WHERE deleted_at IS NULL AND (vencimento BETWEEN :data_ini AND :data_fim) AND pago = 1 ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute([
            'data_ini' => $data_ini,
            'data_fim' => $data_fim
        ]);

        return ServiceResponse::success('ok', $query->fetchAll());
    }

    public function baixar($data){
        $find = $this->find('id', $data['id']);

        if(!$find) return ServiceResponse::error("Conta não encontrada.", null);

        $valorConta = $find->valor;

        if($data['valor'] <= 0) return ServiceResponse::error("O valor da conta precisa ser maior que zero.", null);
        if($data['valor'] > $valorConta) return ServiceResponse::error("O valor a ser pago não pode ser superior ao valor da conta. O valor da conta é: R$ {$find->valor}.", null);
        
        $subtotal = ($valorConta - $data['desconto']) + ($data['multa'] + $data['juros'] + $data['taxa']);
      

        $data['subtotal'] = $subtotal;
        $data['usuario_pgto'] = App::authSession()->get()->id;
        $data['pago'] = 1;
  

        if($data['valor'] < $valorConta){

            $subtotal = ($data['valor'] - $data['desconto']) + ($data['multa'] + $data['juros'] + $data['taxa']);
            
            $data['subtotal'] = $subtotal;

            try{

                $this->connection()->beginTransaction();

                $this->columns = [
                    'id',
                    'subtotal',
                    'juros',
                    'multa',
                    'taxa',
                    'data_pgto',
                    'forma_pgto',
                    'desconto',
                    'usuario_pgto',
                    'pago',
                ];

                $update = $this->update('id', $data);

                if (!$update) {
                    $this->connection()->rollBack();
                    return ServiceResponse::error("Erro ao atualizar a conta.", $data);
                }

                $this->columns = [...$this->columns, 'id_ref'];

                $desc = null;
                
                $referencia = $this->find('id_ref', $find->id);
                
                if($find->id_ref){
                    $referencia = $this->find('id_ref', $find->id_ref);
                }
                
                $valor = floatval($find->valor) - floatval($data['valor']);

                if($referencia){
                    $valor = floatval($referencia->valor) - floatval($data['valor']);
                    $desc = $referencia->descricao;
                }else{
                    $desc = "(Resíduo) " . $find->descricao;
                }
               
                $insert = $this->insert([
                    'descricao' => $desc,
                    'cliente' => $find->cliente,
                    'valor' => $valor,
                    'vencimento' => $find->vencimento,
                    'data_pgto' => null,
                    'data_lanc' => (new DateTime())->format('Y-m-d H:i:s'),
                    'forma_pgto' => null,
                    'frequencia' => $find->frequencia,
                    'arquivo' => $find->arquivo,
                    'observacao' => $find->observacao,
                    'id_ref' => $find->id,
                    'subtotal' => 0.00,
                    'usuario_lanc' => App::authSession()->get()->id,
                ]);
                
                if (!$insert) {
                    $this->connection()->rollBack();
                    return ServiceResponse::error("Erro ao inserir valor residual da conta.", $data);
                }
            

            $this->connection()->commit();

            if($update) return ServiceResponse::success('Conta baixada com sucesso!', $data);

            
            }catch(\Exception $e){
                $this->connection()->rollBack();
                return ServiceResponse::error("Erro na transação: " . $e->getMessage(), $data);
            }
            
        }
        
        
        
        try{

            $this->connection()->beginTransaction();

            $this->columns = [
                'id',
                'subtotal',
                'juros',
                'multa',
                'taxa',
                'data_pgto',
                'forma_pgto',
                'desconto',
                'usuario_pgto',
                'pago',
            ];
            
            $update = $this->update('id', $data);

            if (!$update) {
                $this->connection()->rollBack();
                return ServiceResponse::error("Erro ao atualizar a conta.", $data);
            }

            if($find->frequencia){
                $frequencia = (new FrequenciasService())->find('id', $find->frequencia);

                $vencimento = date('Y-m-d', strtotime("{$frequencia->dias} days", strtotime($find->vencimento)));

                $insert = $this->insert([
                'descricao' => $find->descricao,
                'cliente' => $find->cliente,
                'valor' => $find->valor,
                'vencimento' => $vencimento,
                'data_pgto' => null,
                'data_lanc' => (new DateTime())->format('Y-m-d H:i:s'),
                'forma_pgto' => null,
                'frequencia' => $find->frequencia,
                'arquivo' => $find->arquivo,
                'observacao' => $find->observacao,
                'referencia' => $find->referencia,
                'subtotal' => $find->subtotal,
                'usuario_lanc' => App::authSession()->get()->id,
            ]);
        
            if (!$insert) {
                $this->connection()->rollBack();
                return ServiceResponse::error("Erro ao gerar nova conta.", $data);
            }
        }

        $this->connection()->commit();

        if($update) return ServiceResponse::success('Conta baixada com sucesso!', $data);

        
        }catch(\Exception $e){
            $this->connection()->rollBack();
            return ServiceResponse::error("Erro na transação: " . $e->getMessage(), $data);
        }
                
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
            'frequencia',
            'arquivo',
            'observacao',
            'referencia',
            'id_ref',
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

        $this->columns = ['id', 'deleted_at', 'user_deleted'];

        // if($find->arquivo && file_exists(UPLOAD_DIR . $find->arquivo)){
        //     unlink(UPLOAD_DIR . $find->arquivo);
        // }
        $user = App::authSession()->get()->id;
        
        $find = (new UsuariosService())->find('id', $user);

        if(!$find) return ServiceResponse::error("Não foi possível excluir a parcela.", null);

        $delete = $this->update('id', ['deleted_at' => (new DateTime())->format('Y-m-d H:i:s'), 'id' => $id, 'user_deleted' => $find->id]);

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
