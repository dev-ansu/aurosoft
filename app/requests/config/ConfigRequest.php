<?php

namespace app\requests\config;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;

class ConfigRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'nome' => 'required|notNull', 
            'email' => 'required|notNull', 
            'telefone' => 'required|notNull', 
            'whatsapp' => 'required|notNull', 
            'instagram' => 'required|notNull', 
            'rua' => 'required|notNull',
            'bairro' =>'required|notNull',
            'numero'=>'required|notNull'
        ];
    }
    
    public function messages(): array{
        return [

            'nome.notNull' => "O campo nome não pode ser vazio.",
            'nome.required' => "O campo de nome é obrigatório.",
            
            'email.notNull' => "O campo e-mail não pode ser vazio.",
            'email.required' => "O campo de e-mail é obrigatório.",
            
            'telefone.notNull' => "O campo telefone não pode ser vazio.",
            'telefone.required' => "O campo de telefone é obrigatório.",
            
            'whatsapp.notNull' => "O campo whatsapp não pode ser vazio.",
            'whatsapp.required' => "O campo de whatsapp é obrigatório.",
            
            'instagram.notNull' => "O campo instagram não pode ser vazio.",
            'instagram.required' => "O campo de instagram é obrigatório.",
            
            'rua.notNull' => "O campo rua não pode ser vazio.",
            'rua.required' => "O campo de rua é obrigatório.",
            
            'numero.notNull' => "O campo numero não pode ser vazio.",
            'numero.required' => "O campo de numero é obrigatório.",
            
            'bairro.notNull' => "O campo bairro não pode ser vazio.",
            'bairro.required' => "O campo de bairro é obrigatório.",
            
            'id.notNull' => "O campo id não pode ser vazio.",
            'id.required' => "O campo de id é obrigatório.",
            
        ];
    }

}