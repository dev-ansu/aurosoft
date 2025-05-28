<?php

namespace app\requests\acessos;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class AcessosRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'nome_acesso' => 'required|notNull',
            'chave' => 'required|notNull',
            'grupo_id' => 'optional',
        ];
    }
    
    public function messages(): array{
        return [
            'nome_acesso.required' => "O campo nome do menu é obrigatório.",
            'nome_acesso.notNull' => "O campo nome do menu não pode ser vazio.",
            
            'chave.required' => "O campo chave é obrigatório.",
            'chave.notNull' => "O campo chave não pode ser vazio.",
 


        ];
    }

}
