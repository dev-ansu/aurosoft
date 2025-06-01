<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AddConfigInitialData extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'nome' => 'Nome sistema',
                'email' => 'sistema@gmail.com',
                'telefone' => '558599999999',
                'whatsapp' => '558599999999',
                'instagram' => '@sistema',
                'rua' => 'ali',
                'numero' => 3333,
                'bairro' => 'acolá',
                'ativo' => 'Sim',
            ]
        ];
        $users = $this->table("config");
        $existingUser = $this->fetchRow("SELECT * FROM config WHERE email = 'sistema@gmail.com'");
        
        if($existingUser){
            $this->execute(
                'UPDATE config SET ativo = "Sim" WHERE email = "sistema@gmail.com"'
            );
            return;
        }else{
            $users->insert($data)->save();
        }
    }
}
