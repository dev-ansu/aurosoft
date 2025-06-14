<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnOnAcessosTable extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('acessos');
        $table
            ->addColumn('pagina', 'string', ['limit' => 5, 'null' => true, 'default' => 'Não'])
            ->save()
        ;
    }

    public function down():void{
        $this->table("acessos")->removeColumn("pagina")->save();
    }
}
