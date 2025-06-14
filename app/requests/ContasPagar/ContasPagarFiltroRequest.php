<?php

namespace app\requests\ContasPagar;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class ContasPagarFiltroRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'data_ini' => 'required|valideISODate',
            'data_fim' => 'required|valideISODate',
            'situacao' => 'optional|patternValues:[ab,at,pg]',
        ];
    }
    
    public function messages(): array{
        return [
            
        ];
    }

}
