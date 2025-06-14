<?php

namespace app\requests\InserirPermissoes;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class InserirPermissoes extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'cargo_id' => 'required|notNull',
            'permissao_id' => 'required|notNull',
        ];
    }
    
    public function messages(): array{
        return [
            'cargo_id.notNull' => "O id do usuário é obrigatório.",
            'permissao_id.notNull' => "O id da permissão é obrigatório.",
        ];
    }

}
