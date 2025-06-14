<?php
namespace app\classes;

use app\requests\RequestValidation;
use Closure;

class InputData{

    protected RequestValidation $validatorInstance;

    public function __construct(protected array $data)
    {
        
    }

    public function data(): array{
        return $this->data;
    }

    /**
     * Este método valida os campos de uma requisição de acordo com uma classe de instância @var RequestValidation
     * @param RequestValidator $validationClass - a classe de validação que será usada
     * @param ?Closure $customizer - caso você precise customizar alguma validação
     * @return ?RequestValidation
     */
    public function validate(string $validationClass, ?Closure $customizer = null): RequestValidation | array | null{

        /** @var RequestValidation $validator */
        $validator = new $validationClass;

        // Aplica as customizações antes de validar
        if($customizer){
            $customizer($validator);
        }
        
        $this->validatorInstance = $validator;

        $validated = $validator->validated();

 
        return $validated;
    }


    public function errors():array{
        return $this->validatorInstance?->errors() ?? [];
    }

    public function get(string $key, $default = null){
        return $this->data[$key] ?? $default;
    }
}