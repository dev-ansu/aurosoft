<?php

namespace app\services\ContasReceber;

use app\core\ServiceResponse;
use app\core\Model;
use app\facade\App;
use app\services\Frequencias\FrequenciasService;
use app\services\Usuarios\UsuariosService;
use DateInterval;
use DateTime;
use DateTimeZone;
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
    
    public function fetchAllByKey($key, $value): ServiceResponse
    {
        $sql = "SELECT {$this->table}.*, f.frequencia as nome_frequencia, fp.nome as forma_pagamento, fp.taxa as taxa_forma_pgto FROM {$this->table} 
            LEFT JOIN formas_pagamento fp ON fp.id = {$this->table}.forma_pgto
            LEFT JOIN frequencias f ON f.id = {$this->table}.frequencia WHERE {$key} = :{$key} AND deleted_at IS NULL ORDER BY vencimento
        ";
        $query = $this->connection()->prepare($sql);
        $query->execute([$key => $value]);

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

    private function baixarContaAMenor($data, $find){
        
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

                $referencia = $this->find('id_ref', $find->id_ref);
                                
                $valor = floatval($find->valor) - floatval($data['valor']);

                if($referencia){
                    $valor = floatval($referencia->valor) - floatval($data['valor']);
                 }

                 $frequencia = $find->frequencia;
                $id_ref = $find->id;
                
                if($referencia && property_exists($referencia, 'id_ref')) {
                    $id_ref = $referencia->id_ref;
                }
                if($referencia && property_exists($referencia, 'frequencia')) {
                    $id_ref = $referencia->frequencia;
                }

               
                $insert = $this->insert([
                    'descricao' => $find->descricao,
                    'cliente' => $find->cliente,
                    'valor' => $valor,
                    'vencimento' => $find->vencimento,
                    'data_pgto' => null,
                    'data_lanc' => (new DateTime())->format('Y-m-d H:i:s'),
                    'forma_pgto' => null,
                    'frequencia' => $frequencia,
                    'arquivo' => $find->arquivo,
                    'referencia' => 'Resíduo',
                    'observacao' => $find->observacao,
                    'id_ref' => $id_ref,
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

    public function parcelar($data){
        $find = $this->find('id', $data['id']);


        if(!$find) return ServiceResponse::error("Conta não encontrada.", null);

        $frequencia = (new FrequenciasService())->find('id', $data['frequencia']);

        if(!$frequencia) return ServiceResponse::error("Frequência não encontrada.", null);

        $trash = $this->delete('id', $data['id']);

        $dias = $frequencia->dias;
        $qtdParcelas = $data['qtd_parcelas'];
        $valor = $find->valor / $qtdParcelas;
        $i = 1;
        
        $vencimentoBase = new DateTime($find->vencimento);

        while($i <= $qtdParcelas){
            $vencimento = clone $vencimentoBase;

                // Se for frequência mensal (30 dias), tratamos de forma especial
            if($dias == 30 || $dias == 31) {
                $vencimento->add(new DateInterval('P' . $i . 'M')); // Adiciona meses
            }elseif($dias == 180){
                $vencimento->add(new DateInterval('P' . ($i * 6) . 'M')); // Adiciona anos
            }
            elseif($dias == 360) {
                $vencimento->add(new DateInterval('P' . ($i * 12) . 'M')); // Adiciona anos
            }
            // Para outras frequências (diária, semanal, quinzenal, bimestral, etc.)
            else {
                $vencimento->add(new DateInterval('P' . ($i * $dias) . 'D')); // Adiciona dias exatos
            }
             
             $this->insert([
                'descricao' => $find->descricao,
                'cliente' => $find->cliente,
                'valor' => $valor,
                'vencimento' => $vencimento->format('Y-m-d'),
                'data_pgto' => null,
                'data_lanc' => (new DateTime())->format('Y-m-d H:i:s'),
                'forma_pgto' => null,
                'frequencia' => null,
                'arquivo' => $find->arquivo,
                'observacao' => $find->observacao,
                'referencia' => null,
                'id_ref' => $find->id_ref,
                'subtotal' => $find->subtotal,
                'usuario_lanc' => App::authSession()->get()->id,
            ]);

            $i++;
        }


        if($trash){
            return ServiceResponse::success('Conta parcelada com sucesso.', $data);
        }

        return ServiceResponse::error("A conta não foi parcelada.", null);

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
            return $this->baixarContaAMenor($data, $find);          
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
           
                $vencimentoBase = new DateTime($find->vencimento);
           
                $frequencia = (new FrequenciasService())->find('id', $find->frequencia);

                $dias = $frequencia->dias;

                $vencimento = clone $vencimentoBase;

                // Se for frequência mensal (30 dias), tratamos de forma especial
                if($dias == 30 || $dias == 31) {
                    $vencimento->add(new DateInterval('P' . 1 . 'M')); // Adiciona meses
                }elseif($dias == 180){
                    $vencimento->add(new DateInterval('P' . 6 . 'M')); // Adiciona anos
                }
                elseif($dias == 360) {
                    $vencimento->add(new DateInterval('P' . 12 . 'M')); // Adiciona anos
                }
                // Para outras frequências (diária, semanal, quinzenal, bimestral, etc.)
                else {
                    $vencimento->add(new DateInterval('P' . $dias . 'D')); // Adiciona dias exatos
                }

                $this->columns = [...$this->columns, 'id_ref'];

                $referencia = $this->find('id_ref', $find->id_ref);
                

                $id_ref = $find->id;
                
                if($referencia && property_exists($referencia, 'id_ref')) {
                    $id_ref = $referencia->id_ref;
                    $find = $this->find('id', $id_ref);

                    $vencimentoBase = new DateTime($find->vencimento);

                    $vencimento = clone $vencimentoBase;

                    $vencimento->add(new DateInterval('P' . 1 . 'M')); // Adiciona meses

                    $insert = $this->insert([
                        'descricao' => $find->descricao,
                        'cliente' => $find->cliente,
                        'valor' => $find->valor,
                        'vencimento' => $vencimento->format('Y-m-d'),
                        'data_pgto' => null,
                        'data_lanc' => (new DateTime())->format('Y-m-d H:i:s'),
                        'forma_pgto' => null,
                        'frequencia' => $find->frequencia,
                        'arquivo' => $find->arquivo,
                        'observacao' => $find->observacao,
                        'referencia' => $find->referencia,
                        'id_ref' => null,
                        'subtotal' => null,
                        'usuario_lanc' => App::authSession()->get()->id,
                    ]);
            
                if (!$insert) {
                    $this->connection()->rollBack();
                    return ServiceResponse::error("Erro ao gerar nova conta.", $data);
                }
                }else{

                    $insert = $this->insert([
                        'descricao' => $find->descricao,
                        'cliente' => $find->cliente,
                        'valor' => $find->valor,
                        'vencimento' => $vencimento->format('Y-m-d'),
                        'data_pgto' => null,
                        'data_lanc' => (new DateTime())->format('Y-m-d H:i:s'),
                        'forma_pgto' => null,
                        'frequencia' => $find->frequencia,
                        'arquivo' => $find->arquivo,
                        'observacao' => $find->observacao,
                        'referencia' => $find->referencia,
                        'id_ref' => $find->id_ref,
                        'subtotal' => $find->subtotal,
                        'usuario_lanc' => App::authSession()->get()->id,
                    ]);

        
                    if (!$insert) {
                        $this->connection()->rollBack();
                        return ServiceResponse::error("Erro ao gerar nova conta.", $data);
                    }

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
            'id',
            "descricao",
            "valor",
            "cliente",
            'vencimento',
            "data_pgto",
            "forma_pgto",
            "frequencia",
            "observacao",
            "arquivo",
            'usuario_lanc',
        ];
        
        $data['subtotal'] = $data['valor'];

        if($data['arquivo'] && $find->arquivo){
            unlink(UPLOAD_DIR . $find->arquivo);
        }else{
            $data['arquivo'] = $find->arquivo;
        }
        
        $update = $this->update('id', $data);

        if($update){
           
            return ServiceResponse::success('Conta atualizada com sucesso.', $data);
        }

        return ServiceResponse::error("A conta não foi atualizada.", $data);

    }

}
