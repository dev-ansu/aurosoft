<?php

namespace app\requests\ContasReceber;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class ParcelarContaRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'id' => 'required|notNull|numberInt',
            'frequencia' => 'required|notNull|numberInt',
            'qtd_parcelas' => 'required|notNull|numberInt',
        ];
    }
    
    public function messages(): array{
        return [

            'frequencia.required' => "O campo frequência é obrigatório.",
            'frequencia.notNull' => "O campo frequência não pode ser vazio.",
            'frequencia.numberInt' => "O campo frequência deve ser um inteiro válido.",

            'qtd_parcelas.required' => "O campo qtd. parcelas é obrigatório.",
            'qtd_parcelas.notNull' => "O campo qtd. parcelas não pode ser vazio.",
            'qtd_parcelas.numberInt' => "O campo qtd. parcelas deve ser um inteiro válido.",


        ];
    }

}
