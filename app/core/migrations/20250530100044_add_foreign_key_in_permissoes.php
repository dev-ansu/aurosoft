<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddForeignKeyInPermissoes extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('permissoes');
        $table
            ->addForeignKey("permissao", "acessos", 'id', [
                'delete' => "RESTRICT",
                'update' => "RESTRICT",
                'constraint' => 'fk_permissoes_acesso_id_acessos_id',
                ])
            ->save()
        ;
    }

    public function down():void{
        $this->table("permissoes")->dropForeignKey('usuario_id',"fk_permissoes_usuario_id_usuarios_id")
        ->dropForeignKey("permissao", "fk_permissoes_acesso_id_acessos_id")
        ->save();
        $this->table("permissoes")->drop()->save();
    }
}
