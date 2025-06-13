<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddForeignKeyUsuariosCargos extends AbstractMigration
{
   public function up(): void{

        $table = $this->table('usuarios');

        $table
            ->addForeignKey("nivel", "cargos","id", [
                'delete' => 'RESTRICT',
                'update' => 'RESTRICT',
                'constraint' => 'fk_cargos_usuarios'
            ])
        ->save();

    }

    public function down(): void{
        $this->table('usuarios')->dropForeignKey('nivel', 'fk_cargos_usuarios')->save();
        $this->table('usuarios')->drop()->save();
    }
}
