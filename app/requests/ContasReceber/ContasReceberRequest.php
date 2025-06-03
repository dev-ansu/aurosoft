<?php

namespace app\requests\contasreceber;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class ContasReceberRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            "descricao" => "optional",
            "valor" => "required|decimal",
            "cliente" => "optional|numberInt",
            'vencimento' => 'required|valideISODate',
            "data_pgto" => "optional|valideISODate",
            "forma_pgto" => "optional|numberInt|existe:app\\services\\FormasPagamento\\FormasPagamentoService>id",
            "frequencia" => "optional|numberInt|existe:app\\services\\Frequencias\\FrequenciasService>id",
            "observacao" => "optional",
        ];
    }
    
    public function messages(): array{
        return [
            "valor.decimal" => "O campo valor deve ser um decimal válido, ex.: 20.33, 154,44.",
            "vencimento.required" => "A data de vencimento é obrigatória.",
            "vencimento.valideISODate" => "O vencimento deve ser uma data válida.",
            "data_pgto.valideISODate" => "O vencimento deve ser uma data válida.",
            "forma_pgto.numberInt" => "A forma de pagamento não é válida.",
            "forma_pgto.existe" => "A forma de pagamento não é válida.",
            "frequencia.existe" => "A frequência escolhida não é válida.",
        ];
    }

}
