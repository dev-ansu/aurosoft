<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnDeletedAtInContasReceber extends AbstractMigration
{
    public function up(): void{
        $table = $this->table("contas_receber");
            $table
                ->addColumn('deleted_at', 'datetime', ['null' => true])
        ->save();
    }

    public function down(): void{
        $this->table('contas_receber')->removeColumn("deleted_at")->save(); 
    }
}
