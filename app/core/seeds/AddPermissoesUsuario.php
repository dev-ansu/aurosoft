<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AddPermissoesUsuario extends AbstractSeed
{
    
    public function run(): void
    {
        $existingUser = $this->fetchRow("SELECT * FROM usuarios WHERE email = 'anderson@gmail.com'");
        $acessos = $this->fetchAll("SELECT * FROM acessos");
        $permissoes = $this->fetchAll("SELECT * FROM permissoes WHERE usuario_id = {$existingUser['id']}");
        
        if(count($permissoes) === 0){
            foreach($acessos as $acesso){
                $this->insert('permissoes', [
                    'usuario_id' => $existingUser['id'],
                    'permissao' => $acesso['id'],
                ]);
            }
        }else{
            $this->execute("DELETE FROM permissoes WHERE usuario_id = {$existingUser['id']}");
            $this->run();
        }
        
    }
}
