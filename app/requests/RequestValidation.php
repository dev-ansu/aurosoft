<?php

namespace app\requests;

use app\classes\Validate;
use app\facade\App;



class RequestValidation extends Validate{

    private $data;
    protected array $fields;
    protected array $customRules = [];
    protected array $customMessages = [];

    public function __construct(){
        self::$method = App::request()->getServer('REQUEST_METHOD') === 'GET' ? $_GET : $_POST;
        self::$request = $this;
    }

    public function data(){
        return $this->data;
    }
    
    public function setFields(array $fields){
        $this->fields = $fields;
    }

    public function getFields(){
        return $this->fields;
    }

    public function setOld(){

        foreach($this->getFields() as $field){
            $value = App::request()->input($field);
            setOld($field, $value);
        }
            
    }

    public function custom(array $rules = []): void{

        if(isset($rules['messages'])){
            $this->customMessages = $rules['messages'];
            unset($rules['messages']);
        }
        
        $this->customRules = $rules;
    }
    
    public function validated(){
        if(Validate::$request->authorize()){

            $combinedRules = array_merge(Validate::$request->rules(), $this->customRules);
            
            $this->setFields(array_keys($combinedRules));
            $validate = $this->validate($combinedRules);
         
            if(!$validate){
                $this->setOld();
                self::setFlashMessages(); // Garante que as mensagens estarão disponíveis.
                return [
                    'error' => true,
                    'issues' => Validate::getErrors(),
                ];                
            }
      

            $this->data = $validate;

            return [
                'error' => false,
                'issues' => $this->data()
            ];
        }else{
            setFlash('message', 'Você não tem autorização para esta ação.');
            redirect();
        }
    }

    public function errors(){
        return Validate::getErrors();
    }

}