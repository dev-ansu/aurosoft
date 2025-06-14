<?php

namespace app\requests\ContasPagar;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class BaixarContaRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'id' => 'required|notNull|numberInt',
            'valor' => 'required|notNull|decimal',
            'forma_pgto' => 'required|notNull|numberInt',
            'data_pgto' => 'required|notNull|valideISODate',
            'multa' => 'optional|decimal',
            'juros' => 'optional|decimal',
            'desconto' => 'optional|decimal',
            'taxa' => 'optional|decimal',
        ];
    }
    
    public function messages(): array{
        return [
            'id.required' => "O id da conta é obrigatório.",
            'id.notNull' => "O id da conta não pode ser vazio.",
            'id.numberInt' => 'O id deve ser um número inteiro válido.',
            
            'forma_pgto.required' => "A forma de pagamento é obrigatória.",
            'forma_pgto.notNull' => "A forma de pagamento não pode ser vazia..",
            'forma_pgto.numberInt' => "A forma de pagamento deve ser um número inteiro válido.",

            'data_pgto.required' => "A data de pagamento é obrigatória.",
            'data_pgto.notNull' => "A data de pagamentonão pode ser vazia..",
            'data_pgto.valideISODate' => "A data de pagamento deve ser uma data válida.",

            'juros.decimal' => 'Os juros devem ser um número decimal válido.',
            'multa.decimal' => 'A multa deve ser um número decimal válido.',
            'desconto.decimal' => 'O desconto deve ser um número decimal válido.',
            'taxa.decimal' => 'A taxa deve ser um número decimal válido.',
        ];
    }

}
