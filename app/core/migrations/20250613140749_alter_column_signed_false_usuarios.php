<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterColumnSignedFalseUsuarios extends AbstractMigration
{
    public function up(): void{

        $table = $this->table('usuarios');

        $table
            ->changeColumn("nivel", 'integer',['signed' => false])
        ->save();

    }

    public function down(): void{
        $this->table('usuarios')->changeColumn('nivel', 'string', ['limit' => 20])->save();
    }
}
