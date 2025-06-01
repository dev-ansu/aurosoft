<?php
namespace app\classes;

use app\core\Model;
use app\facade\App;
use DateTime;

class Validate extends Model{
    
    protected static array $errors = [];
    protected static $method;
    protected static $request;

       
    public static function validate(array $validacoes){
        
        if(!self::$method){
            $method = $_SERVER['REQUEST_METHOD'];
            if(strtolower($method) == 'get'){
                self::$method = $_GET;
            }else{
                self::$method = $_POST;
            }
        }

        $result = [];
        $param = '';
        foreach($validacoes as $field => $validate){

            if(is_array($validate)){
                foreach($validate as $rule => $params){
                    $result[$field] = (!str_contains($rule, "|")) ?
                    self::validacaoUnica($validate, $field, $params):
                    $result[$field] = self::validacaoMultipla($validate, $field, $param);
                }
            }else{                
                $result[$field] = (!str_contains($validate, "|")) ?
                [$validate, $param] = self::validacaoUnica($validate, $field, $param):
                $result[$field] = self::validacaoMultipla($validate, $field, $param);
            }
            
           
        }

        self::setMessages();
        
        if(in_array(false, $result, true)){
            return false;
        }
        return $result;
    }

    private static function validacaoUnica($validate, $field, $param){
        
        if ($validate === 'optional') {
            $value = App::request()->input($field);
            if ($value === null || (is_string($value) && trim($value) === '') || (is_array($value) && count($value) === 0)) {
                return null;
            }
            return $value;
        }

        if(is_array($validate)){
            foreach($validate as $rule => $params){
                return self::$rule($field, $params);
            }
        }else{
            if(str_contains($validate, ":")){
                [$validate, $param] = explode(":", $validate);
            }
        }
        return self::$validate($field, $param);
    }
    
    private static function validacaoMultipla($validate, $field, $param){
        $result = [];
        
        $explodeValidatePipe = explode("|", $validate);
        $isOptional = in_array('optional', $explodeValidatePipe);

        // Se o campo é opcional e está vazio, retorna null
        if($isOptional){
            $value = App::request()->input($field);
            if($value === null || (is_string($value) && trim($value) === '') || (is_array($value) && count($value) === 0)){
                return null;
            }
        }

        foreach($explodeValidatePipe as $validate){
            if(is_array($validate)){
                foreach($validate as $rule => $params){
                    $result[$field] = self::$rule($field, $params);
                }
            }else{                
                if(str_contains($validate, ":")){
                    
                    [$validate, $param] = explode(":", $validate);
                }
            }
               
                $result[$field] = self::$validate($field, $param);

                // if($result[$field] === false || $result[$field] === null){
                //     break;
                // }
            }
            return $result[$field];
    }
    
    private static function patternValues($field, $param){
       
        $data = isset($_REQUEST[$field]) ? strip_tags($_REQUEST[$field]):'';
        $newParam = [];

        if(str_contains($param, '>')){
            $patterns = explode(">", $param);
            $pattern = $patterns[1];
            $newParam = explode(",",trim($patterns[0], '[]'));
            
            if(in_array($data, $newParam)){
                return strip_tags($data);
            }else{
                $data = $pattern;
                return strip_tags($data);
            }

        }else{
            $newParam = explode(",",trim($param, '[]'));
        }
        
        if(in_array($data, $newParam)){
            return strip_tags($data);
        }

        return false;        
    }

    private static function isEquals($field, $param){
        $input = App::request()->input($field);
        $input2= App::request()->input($param);
        
        if((!$input && !$input2) || ($input !== $input2) || !(hash_equals($input, $input2))){
            setFlash($field, 'Os campos não coincidem.');
            self::setError($field, 'isEquals','Os campos não coincidem'); 
            return false;
        }

        return true;
    }

    private static function valideISODate($field){
        $accepted = ['Y-m-d', 'Y-m-d H:i:s'];
        $date = isset($_REQUEST[$field]) ? strip_tags($_REQUEST[$field]):'';

        if($date){
            foreach($accepted as $formato){
                $dateTimeObj = DateTime::createFromFormat($formato, $date);
                if($dateTimeObj !== false && $dateTimeObj->format($formato) === $date){
                    return strip_tags($date);
                }
            }
        }

        return false;
    }

    private static function valideTime($field, $param){
        $valor = isset($_REQUEST[$field]) ? $_REQUEST[$field]:'';
        if($valor){
            $param = str_replace("-", ":", $param);
            if(is_array($valor)){
                $res = array_map(function($v) use($param){
                    $time = date($param, strtotime($v));
                    if($time == $v){
                        return strip_tags($v);
                    }
                }, $valor);
                return $res;
            }
            $time = date($param, strtotime($valor));
            if($time == $valor){
                return strip_tags($valor);
            }
        }
        return false;
    }

    // private static function exist($field){
    //     $value = App::request()->input($field);

    //     $value = $value ? strip_tags($value):'';

    //     if()
        
    // }

    private static function valideNumber($field){
        $valor = isset($_REQUEST[$field]) ? $_REQUEST[$field]:'';

        if($valor){
            $float = floatval($valor);
            if($float == $valor || is_int($valor)){
                return strip_tags($valor);
            }
        }
        return false;
    }

    private static function setMessages(){
        $object = self::$request;
        if(method_exists($object, 'messages')){
            $combinedMessages = array_merge($object->messages(), $object->customMessages);
            if($combinedMessages){
                foreach($combinedMessages as $key => $value){
                    if(str_contains($key,".")){
                        [$field, $method] = explode(".",$key);
                        if(isset(self::$errors[$field][$method])){
                            self::$errors[$field][$method] = $value;
                        }
                    }
                }
            }
        }
    }
    
    public static function setFlashMessages(){
        foreach(self::$errors as $field => $methods){
            foreach($methods as $method => $message){
                setFlash($field.".".$method, $message);
            }
        }
    }

    private static function setError($field, $method, $value){

        if(!isset(self::$errors[$field])){
            self::$errors[$field] = [$method => $value];
        }else{
            self::$errors[$field][$method] = $value;
        }
        return self::class;
    }

    public static function getErrors(){
        self::setMessages();
        return self::$errors;
    }

    private static function required($field){
      
        $value = App::request()->input($field);
        
        if(!$value){
            setFlash($field, 'O campo é obrigatório.');
            self::setError($field, 'required','O campo é obrigatório'); 
            return false;
        };

        if(!is_array($value)){
            if((empty(trim($value)) || trim($value) == '')){
                setFlash($field, 'O campo é obrigatório.');
                self::setError($field, 'required','O campo é obrigatório'); 
                return false;
            }else{
                return strip_tags($value);
            }
        }elseif(is_array($value)){
            if(count(array_values($value)) <= 0){
                setFlash($field, 'O campo é obrigatório.');
                self::setError($field, 'required', 'O campo é obrigatório'); 
                return false;
            }else{
                return array_map(fn($v)=> strip_tags($v), $value);
            }
        }      
          
    }
    private static function numberInt($field){
        $number = App::request()->input($field);
        
        if(filter_var($number, FILTER_VALIDATE_INT) !== false){
            return (int) $number;
        }        
        // setFlash($field, "O campo {$field} deve ser um número inteiro.");
        self::setError($field, 'numberInt', "O campo {$field} deve ser um número inteiro."); 
        return false;
    }

    private static function numberFloat($field){
        $number = App::request()->input($field);
        if(filter_var($number, FILTER_VALIDATE_FLOAT) !== false){
            return $number;
        }        
        return null;
    }

    private static function notNull($field){
        $value = App::request()->input($field);
        
        if(empty($value) || trim($value) == ''){
            setFlash($field, 'O campo não está vazio.');
            self::setError($field, 'notNull', 'O campo não pode ser vazio.'); 
            return false;
        }
        return strip_tags($_REQUEST[$field]);
    }
    private static function email($field){
        $value = App::request()->input($field);
        
        $emailIsValid = filter_var($value, FILTER_VALIDATE_EMAIL);

        if(!$emailIsValid){
            setFlash($field, "O campo precisa ter um {$field} válido.");
            self::setError($field, 'email', "O campo precisa ter um {$field} válido."); 
            return false;
        }
        
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }

    private static function maxlen($field, $param){
        $data = strip_tags($_POST[$field]);
        if(strlen($data) > $param){
            setFlash($field, "O campo {$field} tem um limite de {$param} caracteres.");
            return false;
        }
        return $data;
    }

    private static function minlen($field, $param){
        $data = strip_tags($_POST[$field]);
        if(strlen($data) < $param){
            setFlash($field, "O campo {$field} tem um limite de {$param} caracteres.");
            return false;
        }
        return $data;
    }

    /**
     * Valida um arquivo de imagem
     * [
     *       '$field' => [
     *           "image" => [
     *               'allowedMimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
     *               'allowedExtensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
     *               'maxSize' => 2048
     *       ]],
     *   ];
     */
    private static function image($field, $param){

        

        if(!App::request()->file($field) || App::request()->file($field)->get('error') !== UPLOAD_ERR_OK){
            self::setError($field, 'image', 'Erro ao fazer upload de imagem.');
            return false;
        }

     
        $maxSize = $params['maxSize'] ?? null;
        $file = App::request()->file($field);
        $allowedMimeTypes = (array) $param['allowedMimeTypes'];
        $allowedExtensions = (array) $param['allowedExtensions'];
        
        // Verifica o tipo MIME
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $file->get('tmp_name'));
        finfo_close($fileInfo);

        if(!in_array($mimeType, $allowedMimeTypes)){
            self::setError($field, 'image', 'O arquivo precisa ser uma imagem válida ' . implode(", ", $allowedMimeTypes));
            return false;
        }

        // Verifica a extensão
        $extension = strtolower(pathinfo($file->get('name'), PATHINFO_EXTENSION));

        if(!in_array($extension, $allowedExtensions)){
            self::setError($field, 'image', 'Extensão de imagem não permitida. Extensões permitidas: ' . implode(", ", $allowedMimeTypes));
            return false;
        }

        // Verifica tamanho (se informado em KB no $param, por exemplo: "2048" para 2MB)

        if($maxSize !== null){
            $maxSize = intval($maxSize) * 1024; // converte para bytes
            if($file->get('size') > $maxSize){
                self::setError($field, 'image', "O tamanho do máximo do arquivo é de {$maxSize}KB.");
                return false;
            }
        }

        // Tudo certo, retorna os dados do arquivo
        return $file->data();

    }



    private static function data($field){
        $data = isset($_REQUEST[$field]) ? $_REQUEST[$field]:'';
        $date = '';
        if(str_contains($data, "-")){
            $newDataArray = explode("-", $data);
            $dateArray = [
                "dia" => $newDataArray[2],
                "mes" => $newDataArray[1],
                "ano" => $newDataArray[0]
            ];
            $date = checkdate($dateArray["mes"], $dateArray["dia"], $dateArray["ano"]);
            if($date){   
                // $data = $dateArray["dia"]."/".$dateArray["mes"]."/".$dateArray["ano"];     
                return $data;
            }
        }

        if(str_contains($data, "/")){
            $newDataArray = explode("/", $data);
            $dateArray = [
                "dia" => $newDataArray[0],
                "mes" => $newDataArray[1],
                "ano" => $newDataArray[2]
            ];
            $date = checkdate($dateArray["mes"], $dateArray["dia"], $dateArray["ano"]);
            if($date){   
                return $data;
            }
        }
        setFlash("message", "Defina uma data válida.");
        return false;
    }

    private static function color($field){
        $cor_validate = strip_tags($_REQUEST[$field]);
        $pattern = '/[0-9a-fA-F]{6}$/';
        if(preg_match($pattern, $cor_validate) > 0){
            return $cor_validate;
        }
        return false;
    }

    private static function senha($field){
        $senha = strip_tags($_POST[$field]);
        $newSenha = password_hash($senha, PASSWORD_DEFAULT);
        return $newSenha;
    }
    private static function optional($field){
        $value = isset($_REQUEST[$field]) ? $_REQUEST[$field]:'';
        $data = '';
        
        if(is_array($value)){
            if(count(array_values($value)) > 0){
                return array_map(fn($v)=> strip_tags($v), $value);
            }else{
                return null;
            }
        }
        
        if(isset($_POST[$field])){
            $data = strip_tags($_POST[$field]);
        }

        if(isset($_GET[$field])){
            $data = strip_tags($_GET[$field]);
        }

        if($data){
            return $data;
        }
        return null;
    }
    private static function telefone($field){

        $data = '';

        if(isset($_POST[$field])){
            $data = strip_tags($_POST[$field]);
        }

        if(isset($_GET[$field])){
            $data = strip_tags($_GET[$field]);
        }

        if($data){
            $regex = '/^[0-9]{1,50}$/i';
            $teste = preg_match($regex, $data);
            
            if($teste == 1){
                return $data;
            }else{
                setFlash($field, "Digite um telefone válido. Sem espaços, parênteses e hifen.");
                return null;
            }
        }
        
        return null;
        
    }
    
}