<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ContasPagar extends AbstractMigration
{
   public function up(): void
    {
        $table = $this->table("contas_pagar");
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
        ->addColumn('data_lanc', 'datetime',[
            'default' => 'CURRENT_TIMESTAMP'
        ])
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
        ->addColumn('usuario_lanc', 'integer', ['signed' => false])
        ->addColumn('usuario_pgto', 'integer', ['signed' => false, 'null' => true])
        ->addColumn("pago", 'smallinteger', ['null' => true,'default' => 0])
        ->addColumn('taxa', 'decimal', [
            'precision' => 10,
            'scale' => 2,
            'default' => 0.00,
            'null' => true,
        ])
        ->addColumn('deleted_at', 'datetime', ['null' => true])
        ->addColumn('user_deleted', 'integer', ['null' => true, 'signed' => false])
        ->addForeignKey('user_deleted', 'usuarios', 'id', [
            'delete' => 'RESTRICT',
            'update' => 'RESTRICT',
            'constraint' => 'fk_user_deleted_contas_pagar'
        ])
        ->addForeignKey("usuario_lanc", "usuarios", "id", [
            'delete' => "RESTRICT",
            "update" => "RESTRICT",
            "constraint" => "fk_usuarios_contas_pagar_id_usuarios_lanc"
        ])
        ->addForeignKey("frequencia",'frequencias', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION',
                'constraint' => 'fk_contas_pagar_frequencias'
        ])
        ->addForeignKey("forma_pgto",'formas_pagamento', 'id', [
            'delete' => 'NO_ACTION',
            'update' => 'NO_ACTION',
            'constraint' => 'fk_contas_pagar_formas_pagamento'
        ])
        ->save();
    }

    public function down():void{
        $table = $this->table('contas_pagar');

        $table->changeColumn('data_lanc', 'datetime')->save();
      
        $table->dropForeignKey("frequencia", 'fk_contas_pagar_frequencias')->save();
        $table->dropForeignKey("usuario_lanc", "fk_usuarios_contas_pagar_id_usuarios_lanc")->save();
        $table->removeColumn("usuario_lanc")->save();
        $table->removeColumn("usuario_pgto")->save();
        $table->removeColumn('pago')->save();
        $table->removeColumn('taxa')->save();        
        $table->dropForeignKey('user_deleted','fk_user_deleted_contas_pagar')->save();
        $table->removeColumn("deleted_at")->save(); 
        $table->removeColumn("user_deleted")->save(); 
        $table->dropForeignKey("forma_pgto", 'fk_contas_pagar_formas_pagamento')->save();

        $table->drop()->save();
        
    }
}
