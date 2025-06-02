<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterColumnNameInFormasPagamento extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table("formas_pagamento");
        $table
        ->renameColumn('juros', 'taxa')        
        ->save();
    }

    public function down():void{
    
        $this->table("formas_pagamento")->renameColumn('taxa', 'juros')->save();
        
    }
}
