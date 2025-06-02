<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddForeignKeyInContasReceberFormasPagamento extends AbstractMigration
{   
    public function up(): void{

    $table = $this->table('contas_receber');
        $table 
        ->addForeignKey("forma_pgto",'formas_pagamento', 'id', [
            'delete' => 'NO_ACTION',
            'update' => 'NO_ACTION',
            'constraint' => 'fk_contas_receber_formas_pagamento'
        ])
        ->save();
    }
     
    public function down(): void
    {
        $this->table('contas_receber')->dropForeignKey("forma_pgto", 'fk_contas_receber_formas_pagamento')->save();
    }
}
