<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddTokencolumnInUsuariosTable extends AbstractMigration
{
   public function up(): void
    {
        $table = $this->table("usuarios");
        $table
        ->addColumn("token", "string",[
            'limit' => 150,
            'null' => true,
        ]
        )->save();
    }

    public function down():void{
    
        $this->table("usuarios")->removeColumn("token")->save();
        
    }
}