<?php
namespace app\requests\Usuarios;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;

class UsuariosValidation extends RequestValidation implements RequestValidationContract{

     public function __construct(){
          parent::__construct();
     }
     
     public function authorize():bool{
          return true;;
     }

     public function rules():array{
          return [
               "nome" => "required|notNull",
               "email" => "required|notNull",
               "telefone" => "required|notNull",
               "nivel" => "required|notNull",
               "rua" => "required|notNull",
               "numero" => "required|numberInt",
               "bairro" => "required|notNull",
               "senha" => "required|notNull",
               "senha_conf" => "required|notNull",
          ];
     }

     public function messages(): array{
          return [
               'nome.required' => 'O campo nome é obrigatório.',
               'nome.notNull' => 'O campo nome não pode ser vazio.',
               'email.required' => 'O campo e-mail é obrigatório',
               'email.notNull' => 'O campo e-mail não pode ser vazio.',
               'telefone.required' => "O campo telefone é obrigatório.",
               'telefone.notNull' => "O campo telefone não pode ser vazio.",
               "nivel.required" => "O campo nivel é obrigatório.",
               "nivel.notNull" => "O campo nivel não pode ser vazio.",
               "rua.required" => "O campo rua é obrigatório.",
               "rua.notNull" => "O campo rua não pode ser vazio.",
               "bairro.required" => "O campo bairro é obrigatório.",
               "bairro.notNull" => "O campo bairro não pode ser vazio.",
               "numero.required" => "O campo número é obrigatório.",
               "numero.numberInt" => "O campo número deve ser um inteiro válido.",
          ];
     }

}