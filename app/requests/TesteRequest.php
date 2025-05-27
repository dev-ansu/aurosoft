<?php

namespace app\requests;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class TesteController extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'email' => 'required|notNull',
        ];
    }
    
    public function messages(): array{
        return [
            'email.notNull' => "O campo e-mail não pode ser vazio.",
        ];
    }

}
