<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Fornecedores extends AbstractMigration
{
    public function up(): void{

        $table = $this->table('fornecedores');

        $table
            ->addColumn('nome', 'string')
            ->addColumn('telefone', 'string', ['limit' => 20])
            ->addColumn('email', 'string')
            ->addColumn('rua', 'string')
            ->addColumn('bairro', 'string')
            ->addColumn('numero', 'integer')
            ->addColumn('estado', 'string')
            ->addColumn('cidade', 'string')
            ->addTimestamps()
        ->save();

    }

    public function down(): void{
        $this->table('fornecedores')->drop()->save();
    }
}
