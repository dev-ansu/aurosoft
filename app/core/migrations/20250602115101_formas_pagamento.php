<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FormasPagamento extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table("formas_pagamento");
        $table
        ->addColumn('nome', 'string', ['limit' => 50])
        ->addColumn('juros','decimal',[
            'precision' => 10,
            'scale' => 2,
            'default' => 0.00,
        ])        
        ->save();
    }

    public function down():void{
    
        $this->table("formas_pagamento")->drop()->save();
        
    }
}
