<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ContasReceber extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table("contas_receber");
        $table
        ->addColumn('descricao', 'string', ['limit' => 100, 'null' => true])
        ->addColumn('cliente', 'integer', ['null' => true])        
        ->addColumn('valor', 'decimal', [
            'precision' => 10, // total de dígitos
            'scale' => 2, // dígitos após a vírgula
            'default' => 0.00,
            'null' => false,
        ])
        ->addColumn('vencimento', 'date')
        ->addColumn('data_pgto', 'date', ['null' => true])
        ->addColumn('data_lanc', 'datetime')
        ->addColumn('forma_pgto', 'integer', ['signed'=> false])
        ->addColumn('frequencia', 'integer', ['signed'=> false])
        ->addColumn('arquivo', 'string', ['null' => true])
        ->addColumn('observacao', 'string', ['limit' => 100])
        ->addColumn('referencia', 'string', ['null' => true])
        ->addColumn('id_ref', 'integer', ['null' => true])
        ->addColumn('multa', 'decimal', [
            'precision' => 10, // total de dígitos
            'scale' => 2, // dígitos após a vírgula
            'default' => 0.00,
            'null' => true,
        ])
        ->addColumn('juros', 'decimal', [
            'precision' => 10, // total de dígitos
            'scale' => 2, // dígitos após a vírgula
            'default' => 0.00,
            'null' => true,
        ])
        ->addColumn('desconto', 'decimal', [
            'precision' => 10, // total de dígitos
            'scale' => 2, // dígitos após a vírgula
            'default' => 0.00,
            'null' => true,
        ])
        ->addColumn('subtotal', 'decimal', [
            'precision' => 10, // total de dígitos
            'scale' => 2, // dígitos após a vírgula
            'default' => 0.00,
            'null' => true,
        ])
        ->save();
    }

    public function down():void{
        $this->table("contas_receber")->drop()->save();
        
    }
}
