<?php

namespace app\services\Perfil;

use app\core\Model;
use app\core\ServiceResponse;


class PerfilService extends Model{
    
    protected string $table = 'usuarios';
    protected array $columns = ['id', 'nome', 'email', 'senha', 'telefone', 'rua', 'bairro', 'numero', 'foto', 'created_at', 'updated_at'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function insert($data): ServiceResponse{

        $user = $this->find('email', $data['email']);
        
        if($user) return ServiceResponse::error('Usuário já existe.', null, 409);
        
        if($data['senha'] !== $data['senha_conf']){
            return ServiceResponse::error('Senhas não coincidem.', null);
        }
        
        unset($data['senha_conf']);
        

        $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        
        $response =  $this->create($data);

        if($response) return ServiceResponse::success('Usuário cadastrado com sucesso.', null, 201);

        return ServiceResponse::error('Usuário não cadastrado. Erro interno no servidor.', null, 500);

    }

    public function patch($key, $data): ServiceResponse{
        $this->columns = ['id', 'nome', 'email', 'senha', 'telefone', 'foto', 'rua', 'bairro', 'numero'];

        $user = $this->find($key, $data[$key]);
        $userEmail = $this->find('email', $data['email']);

        if($userEmail->id !== $user->id){
            return ServiceResponse::error("Este e-mail já está cadastrado para outro usuário.", null, 409);
        }


        if(!$user) return ServiceResponse::error("Usuário não encontrado.", null);

        if(isset($data['senha']) && !empty(trim($data['senha']))){
            
            if(!empty($user->senha)){

                $passwordVerify = password_verify($data['senha'], $user->senha);
                
                if(!$passwordVerify){
                    $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
                }else{
                    $this->columns = ['id', 'nome', 'email', 'telefone', 'foto', 'rua', 'bairro', 'numero'];
                }
                
            }else{
                $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
            }
        }else{
            $this->columns = ['id', 'nome', 'email', 'telefone','foto', 'rua', 'bairro', 'numero'];
        }

        unset($data['senha_conf']);
        
        if(file_exists(UPLOAD_DIR . $user->foto)){
            unlink(UPLOAD_DIR . $user->foto);
        }
        
        $response = $this->update($key, $data);

        if($response) return ServiceResponse::success("Usuário atualizado com sucesso.", null, 201);

        return ServiceResponse::error('Usuário não cadastrado. Erro interno no servidor.', null, 500);
    }

    public function fetchAll(): ServiceResponse{
        $columns = array_filter($this->columns, function($item){
            return $item !== 'senha';
        });
 
        $columns = array_values($columns);
 
        $users = $this->all($columns);

        return ServiceResponse::success('', $users);
    }

    public function trash($key, $value): ServiceResponse{
        $find = $this->find($key, $value);
        
        if(!$find) return ServiceResponse::error("Usuário não encontrado.", null);

        $response = $this->delete($key, $value);

        if($response) return ServiceResponse::success("Usuário excluído com sucesso.", null);

        return ServiceResponse::error("O usuário não foi excluído.", null, 500);

    }

    public function activate($key, $value){

        $this->columns = ['id', 'ativo'];

        $find = $this->find($key, $value);
        
        if(!$find) return ServiceResponse::error("Usuário não encontrado.", null);

        $response = $this->update($key, ['id' => $value,'ativo' => 'Sim']);

        if($response) return ServiceResponse::success("Usuário ativado com sucesso.", null);

        return ServiceResponse::error("O usuário não foi ativado.", null, 500);
    }

    public function deactivate($key, $value){
        $find = $this->find($key, $value);
        
        if(!$find) return ServiceResponse::error("Usuário não encontrado.", null);
        
        $this->columns = ['id', 'ativo'];
        
        $response = $this->update($key, ['id' => $find->id, 'ativo' => 'Não']);

        if($response) return ServiceResponse::success("Usuário inativado com sucesso.", null);

        return ServiceResponse::error("O usuário não foi inativado.", null, 500);
    }

}