<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterUsuarioIdPermissoesForCargoIdForeignKey extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('permissoes');
        $table->dropForeignKey('usuario_id', 'fk_permissoes_usuario_id_usuarios_id')->save();
        $table->renameColumn('usuario_id', 'cargo_id')->save();
        $table->addForeignKey('cargo_id','cargos','id',[
            'delete' => 'RESTRICT',
            'update' => 'RESTRICT',
            'constraint' => 'fk_permissoes_cargo_id_cargos_id'
        ])->save();
    }

    public function down(): void{
        $table = $this->table('permissoes');
        $table->dropForeignKey('cargo_id', 'fk_permissoes_cargo_id_cargos_id')->save();
        $table->renameColumn('cargo_id', 'usuario_id')->save();
        $table->addForeignKey('usuario_id','usuarios','id',[
            'delete' => 'RESTRICT',
            'update' => 'RESTRICT',
            'constraint' => 'fk_permissoes_usuario_id_usuarios_id'
        ])->save();
    }
}
