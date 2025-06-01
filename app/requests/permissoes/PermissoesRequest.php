<?php

namespace app\requests\permissoes;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class PermissoesRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'id' => 'required|notNull',
        ];
    }
    
    public function messages(): array{
        return [
            'id.notNull' => "O id do usuário é obrigatório.",
        ];
    }

}
