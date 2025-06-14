<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class GrupoAcessos extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('grupo_acessos');
        $table
            ->addColumn('nome', 'string', ['limit' => 250])
            ->save()
        ;
    }

    public function down():void{
        $this->table("grupo_acessos")->drop()->save();
    }
}
