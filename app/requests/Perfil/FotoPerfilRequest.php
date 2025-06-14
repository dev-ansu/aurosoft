<?php

namespace app\requests\Perfil;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;

use function DI\string;

class FotoPerfilRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{


        return [
            'foto' => [
                "archive" => [
                    'optional' => true,
                    'allowedMimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                    'allowedExtensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                    'maxSize' => 2048
            ]],
        ];
    }
    
    public function messages(): array{
        return [
           
        ];
    }

}
