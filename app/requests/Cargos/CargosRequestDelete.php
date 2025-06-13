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
            'id' => 'required|notNull|numberInt',
        ];
    }
    
    public function messages(): array{
        return [
            'id.required' => "O campo id do cargo é obrigatório.",
            'id.notNull' => "O campo id do cargo não pode ser vazio.",
        ];
    }

}
