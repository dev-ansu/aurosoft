<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnInTableContas extends AbstractMigration
{
    public function up(): void{
        $table = $this->table("contas_receber");
            $table
                ->addColumn("pago", 'string', ['limit' => 5, 'null' => true])
                ->addColumn('taxa', 'decimal', [
                    'precision' => 10,
                    'scale' => 2,
                    'default' => 0.00,
                    'null' => true,
                ])
        ->save();
    }

    public function down(): void{
        $table = $this->table('contas_receber');
        $table->removeColumn('pago')->save();
        $table->removeColumn('taxa')->save();        
    }
}
