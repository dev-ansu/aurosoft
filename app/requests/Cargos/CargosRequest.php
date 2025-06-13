<?php

namespace app\requests\Cargos;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class CargosRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'nome' => 'required|notNull',
        ];
    }
    
    public function messages(): array{
        return [
            'nome.required' => "O campo cargo é obrigatório.",
            'nome.notNull' => "O campo cargo não pode ser vazio.",
        ];
    }

}
