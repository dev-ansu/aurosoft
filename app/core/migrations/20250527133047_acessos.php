<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Acessos extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('acessos');
        $table
            ->addColumn('nome', 'string', ['limit' => 250])
            ->addColumn('chave', 'string', ['limit' => 250])
            ->addColumn('grupo_id', 'integer', ['signed' => false,'null' => true])
            ->addForeignKey(['grupo_id'], 'grupo_acessos', ['id'], [
                'delete' => 'SET NULL',
                'update' => 'RESTRICT',
                'constraint' => 'fk_acessos_grupo_id_grupo_acessos_id'
            ])
            ->save()
        ;
    }

    public function down():void{
        $this->table('acessos')->dropForeignKey('grupo_id', 'fk_acessos_grupo_id_grupo_acessos_id');
        $this->table("acessos")->drop()->save();
    }
}
