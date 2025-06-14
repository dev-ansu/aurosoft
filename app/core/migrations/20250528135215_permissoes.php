<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Permissoes extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('permissoes');
        $table
            ->addColumn('usuario_id', 'integer', ['signed' => false])
            ->addColumn('permissao', 'integer', ['signed' => false])
            ->addForeignKey('usuario_id', 'usuarios', 'id', [
                'delete' => 'RESTRICT',
                'update' => 'RESTRICT',
                'constraint' => 'fk_permissoes_usuario_id_usuarios_id'
            ])
            ->save()
        ;
    }

    public function down():void{
        $this->table("permissoes")->drop()->save();
    }
}
