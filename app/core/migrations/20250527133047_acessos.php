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
            ->addColumn('grupo_id', 'integer', ['signed' => false,'null' => false])
            ->addForeignKey(['grupo_id'], 'grupo_acessos', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
                'constraint' => 'fk_acessos_grupo_id_grupo_acessos_id'
            ])
            ->create()
        ;
    }

    public function down():void{
        $this->table("acessos")->drop()->save();
    }
}
