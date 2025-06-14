<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnUserDeletedInContasReceber extends AbstractMigration
{
    public function up(): void{
        $table = $this->table("contas_receber");
            $table
                ->addColumn('user_deleted', 'integer', ['null' => true, 'signed' => false])
                ->addForeignKey('user_deleted', 'usuarios', 'id', [
                    'delete' => 'RESTRICT',
                    'update' => 'RESTRICT',
                    'constraint' => 'fk_user_deleted_contas_receber'
                ])
        ->save();
    }

    public function down(): void{
        $table = $this->table('contas_receber');
        $table->dropForeignKey('user_deleted','fk_user_deleted_contas_receber')->save();
        $table->removeColumn("user_deleted")->save(); 
    }
}
