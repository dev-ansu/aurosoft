<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddForeignKeyInContasReceberFrequencias extends AbstractMigration
{
    public function up(): void{

        $table = $this->table('contas_receber');
            $table 
            ->addForeignKey("frequencia",'frequencias', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION',
                'constraint' => 'fk_contas_receber_frequencias'
            ])
            ->save();
        }
     
    public function down(): void
    {
        $this->table('contas_receber')->dropForeignKey("frequencia", 'fk_contas_receber_frequencias')->save();
    }
}
