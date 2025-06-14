<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Frequencias extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('frequencias');
        $table 
        ->addColumn('frequencia', 'string', ['limit' => 50])
        ->addColumn('dias', 'integer', ['null' => false, 'default' => 0])
        ->save();

    }
     
    public function down(): void
    {
        $this->table('frequencias')->drop()->save();
    }
}
