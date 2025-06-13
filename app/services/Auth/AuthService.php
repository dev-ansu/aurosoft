<?php

namespace app\services\Auth;

use app\core\DBManager;

class AuthService extends DBManager{
    
    protected $table = 'usuarios';

    /**
     * Autenticar o usuário no sistema
     * @param array $data[$email, $senha]
     */
    public function execute(array $data){
        extract($data);
        $sql = "SELECT {$this->table}.*, c.id as cargo_id, c.nome as cargo_nome FROM {$this->table} 
         LEFT JOIN cargos c ON c.id = {$this->table}.nivel
         WHERE email = :email";
        $db = $this->connection();
        $prepare = $db->prepare($sql);
        
        $prepare->execute([
            'email' => $email
        ]);

        $user = $prepare->fetch();

        if(!$user) return false;
        
        $passwordVerify = password_verify($senha, $user->senha);

        if(!$passwordVerify) return false;

        unset($user->senha);
        
        return $user;

    }

}