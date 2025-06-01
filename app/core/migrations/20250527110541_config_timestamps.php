<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ConfigTimestamps extends AbstractMigration
{
    public function up(): void{
        $table = $this->table('config');
        $table
            ->addTimestamps()
            ->save()
        ;
    }

    public function down():void{
        $this->table("config")->removeColumn('created_at')->save();
        $this->table("config")->removeColumn('updated_at')->save();
    }
}
