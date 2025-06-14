<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Cargos extends AbstractMigration
{
     public function up(): void{

        $table = $this->table('cargos');

        $table
            ->addColumn('nome', 'string', ['limit' => 50])
        ->save();

    }

    public function down(): void{
        $this->table('cargos')->drop()->save();
    }
}
