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
                    'update' => 'RESTRICT'
                ])
        ->save();
    }

    public function down(): void{
        $this->table('contas_receber')->removeColumn("user_deleted")->save(); 
    }
}
