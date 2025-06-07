<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterColumnFromContasReceber extends AbstractMigration
{
      public function up(): void{
        $table = $this->table("contas_receber");
            $table
                ->changeColumn('pago', 'smallinteger', ['null' => true,'default' => 0])
        ->save();
    }

    public function down(): void{
        $this->table('contas_receber')->changeColumn("pago", 'string', ['limit' => 5, 'null' => true])->save(); 
    }
}
