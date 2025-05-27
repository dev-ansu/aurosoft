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
                'bairro' => 'acolá'
            ]
        ];
        $users = $this->table("config");
        $existingUser = $this->fetchRow("SELECT * FROM config WHERE email = 'anderson@gmail.com'");
        
        if($existingUser){
            return;
        }else{
            $users->insert($data)->save();
        }
    }
}
