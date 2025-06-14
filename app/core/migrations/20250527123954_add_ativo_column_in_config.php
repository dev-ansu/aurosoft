<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddAtivoColumnInConfig extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('config');
        $table
            ->addColumn('ativo', 'string', ['limit' => 5])
            ->save()
        ;
    }

    public function down():void{
        $this->table("config")->removeColumn('ativo')->save();
    }
}
