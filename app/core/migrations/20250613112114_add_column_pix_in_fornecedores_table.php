<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnPixInFornecedoresTable extends AbstractMigration
{
    public function up(): void{

        $table = $this->table('fornecedores');

        $table
            ->addColumn('pix', 'string')
        ->save();

    }

    public function down(): void{
        $this->table('fornecedores')->removeColumn('pix')->save();
    }
}
