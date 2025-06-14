<?php

namespace app\services\Config;

use app\core\Model;
use app\core\ServiceResponse;

class ConfigService extends Model{
    
    protected string $table = 'config';
    protected array $columns = ['id', 'nome', 'email', 'telefone', 'whatsapp', 'instagram', 'rua', 'bairro', 'numero', 'created_at', 'updated_at'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }


    public function fetch(){
        $sql = 'SELECT * FROM config';
        
        $stmt = $this->connection($this->name)->prepare($sql);
        
        $stmt->execute();


        $result = $stmt->fetch();
        
        return $result;

    }

    public function put($data): ServiceResponse{
        $this->columns = ['id', 'nome', 'email', 'telefone', 'whatsapp', 'instagram', 'rua', 'bairro', 'numero'];
        
        $key = 'id';

        $find = $this->find($key, $data['id']);

        if(!$find){
            return ServiceResponse::error("Configurações não encontradas.", null, 409);
        }

        $updated = $this->update($key, $data); 

        $config = $this->fetch();

        if($updated){
            return ServiceResponse::success("Configurações atualizadas com sucesso.", $config, 201);
        }
      
        return ServiceResponse::error("Configurações não foram atualizadas.", null, 500);
        
    }

}