<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Arquivos extends AbstractMigration
{
    public function run(): void{
        $table = $this->table("arquivos");

        $table
            ->addColumn('user_id', 'integer', ['signed' => false])
            ->addColumn('registro_id','integer', ['signed' => false, 'null' => true])
            ->addColumn('nome', 'string', ['null' => true])
            ->addColumn('descricao', 'text',['null' => true])
            ->addColumn('arquivo', 'string')
            ->addTimestamps()
            ->addColumn('deleted_at', 'datetime', ['null' => true])
        ->save();
    }

    public function down(): void{
        $this->table('arquivos')->drop()->save();
    }
}
