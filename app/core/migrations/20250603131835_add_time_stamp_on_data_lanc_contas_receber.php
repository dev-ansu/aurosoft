<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddTimeStampOnDataLancContasReceber extends AbstractMigration
{
    public function up(): void{

        $table = $this->table('contas_receber');

        $table->changeColumn('data_lanc', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP'
        ])->save();

    }

    public function down(): void{
        $table = $this->table('contas_receber');

        $table->changeColumn('data_lanc', 'datetime')->save();
    }
}
