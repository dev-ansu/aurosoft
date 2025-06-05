<?php

namespace app\requests\Acessos;

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
            'pagina' => 'required|patternValues:[Sim,Não]>Não',
            'grupo_id' => 'optional',
        ];
    }
    
    public function messages(): array{
        return [
            'nome_acesso.required' => "O campo nome do menu é obrigatório.",
            'nome_acesso.notNull' => "O campo nome do menu não pode ser vazio.",
            
            'chave.required' => "O campo chave é obrigatório.",
            'chave.notNull' => "O campo chave não pode ser vazio.",
    
            'pagina.patternValues' => 'O campo página deve ser Sim ou Não.'

        ];
    }

}
