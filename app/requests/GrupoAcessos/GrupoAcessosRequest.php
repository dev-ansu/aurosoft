<?php

namespace app\requests\GrupoAcessos;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;

class GrupoAcessosRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'nome_grupo' => 'required|notNull', 
        ];
    }
    
    public function messages(): array{
        return [

            'nome_grupo.notNull' => "O campo nome do grupo não pode ser vazio.",
            'nome_grupo.required' => "O campo de nome do grupo é obrigatório.",
            
        ];
    }

}