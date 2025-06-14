<?php

namespace app\requests\ContasReceber;

use app\contracts\RequestValidationContract;
use app\requests\RequestValidation;


class ContasReceberArquivoRequest extends RequestValidation implements RequestValidationContract{

    public function __construct(){
        parent::__construct();
    }

    public function authorize(): bool{
        return true;
    }

     public function rules(): array{


        return [
            'arquivo' => ["archive" => [
                    'optional' => true,
                    'allowedMimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/pdf',
                        'application/vnd.rar',
                        'application/zip',
                        'application/xml', // ou 'text/xml', dependendo do uso
                    ],
                    'allowedExtensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp','xls',
                        'xlsx',
                        'doc',
                        'docx',
                        'pdf',
                        'rar',
                        'zip',
                        'xml'],
                    'maxSize' => 2048
            ]],
        ];
    }
    
    public function messages(): array{
        return [
           
        ];
    }

}
