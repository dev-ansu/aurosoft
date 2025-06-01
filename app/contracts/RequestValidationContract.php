<?php
namespace app\contracts;


interface RequestValidationContract{

    public function authorize():bool;

    public function rules(): array;
    
    public function messages(): array;

}