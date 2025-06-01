<?php

namespace app\services\recuperarsenha;

use app\core\ServiceResponse;
use app\core\Model;

class RecuperarSenhaService extends Model{

    protected string $table = 'usuarios';
    protected array $columns = ['email', 'token'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function fetchAll(): ServiceResponse
    {
        return ServiceResponse::success('ok', $this->all());
    }

    public function recuperarSenha($data){
        $user = $this->find("email", $data['email']);

        if(!$user) return ServiceResponse::error("Usuário não encontrado", null, 404); 

        $updated = $this->update('email', [
            'token' => hash('sha256', time()),
            'email' => $data['email']
        ]);
    
        if($updated) return ServiceResponse::success("Token gerado com sucesso. Senha enviada para seu e-mail.", null);
        

        
        return ServiceResponse::error("Ocorreu um erro.", null, 404);
        

    }

}
