<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Config extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('config');
        $table
            ->addColumn('nome', 'string', ['limit' => 250])
            ->addColumn('email', 'string', ['limit' => 250])
            ->addColumn('telefone', 'string', ['limit' => 20])
            ->addColumn('whatsapp', 'string', ['limit' => 20])
            ->addColumn('instagram', 'string', ['limit' => 50])
            ->addColumn('rua', 'string', ['limit' => 50])
            ->addColumn('numero', 'integer')
            ->addColumn('bairro', 'string', ['limit' => 50])
            ->save()
        ;
    }

    public function down():void{
        $this->table("config")->drop()->save();
    }
}
