<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnsInContasReceber extends AbstractMigration
{
    public function up():void{
        
        $table = $this->table("contas_receber");
        $table
            ->addColumn('usuario_lanc', 'integer', ['signed' => false])
            ->addColumn('usuario_pgto', 'integer', ['signed' => false, 'null' => true])
            ->addForeignKey("usuario_lanc", "usuarios", "id", [
                'delete' => "RESTRICT",
                "update" => "RESTRICT",
                "constraint" => "fk_usuarios_contas_receber_id_usuarios_lanc"
            ])
            ->save()
            ;
    }

    public function down():void{
        $this->table('contas_receber')->dropForeignKey("usuario_lanc", "fk_usuarios_contas_receber_id_usuarios_lanc")->save();
        $this->table('contas_receber')->removeColumn("usuario_lanc")->save();
        $this->table('contas_receber')->removeColumn("usuario_pgto")->save();
    }
}
