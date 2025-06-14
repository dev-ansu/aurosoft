<?php

namespace app\requests\Frequencias;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class FrequenciasRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'nome_frequencia' => 'required|notNull',
            'dias' => 'required|notNull|numberInt|isPositive'
        ];
    }
    
    public function messages(): array{
        return [
            'nome_frequencia.notNull' => "O nome da frequência não pode ser vazio.",
            'nome_frequencia.required' => "O nome da frequência é obrigatório.",
            'dias.numberInt' => 'O número de dias é obrigatório e deve ser um inteiro positivo.',
            'dias.isPositive' => 'O número de dias é obrigatório e deve ser um inteiro positivo.',
        ];
    }

}
