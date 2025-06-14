<?php

namespace app\requests\FormasPagamento;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class FormasPagamentoRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'nome_forma_pagamento' => 'required|notNull',
            'taxa' => 'optional|decimal',
        ];
    }
    
    public function messages(): array{
        return [
            'nome_forma_pagamento.notNull' => "O nome da forma de pagamento não pode ser vazio.",
            'nome_forma_pagamento.required' => "nome da forma de pagamento é obrigatório.",
            "taxa.decimal" => 'O campo taxa deve ser um decimal válido, ex.: 154.33.'
        ];
    }

}
