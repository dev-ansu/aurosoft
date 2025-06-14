<?php

namespace app\requests\RecuperarSenha;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class RecuperarSenhaRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'email' => 'required|notNull|email',
        ];
    }
    
    public function messages(): array{
        return [
            'email.required' => "O campo e-mail é obrigatório.",
            'email.notNull' => "O campo e-mail não pode estar vazio.",
            'email.email' => 'Digite um e-mail válido.'
        ];
    }

}
