<?php
namespace app\classes;


class CLI{

    public function init(mixed $argv){
        $commands = $argv;

        array_shift($commands);

        if (isset($commands[0])) {
            if ($commands[0] === 'routes:cache') {
                array_shift($commands);
                $this->routesCache($commands);
            }

            if ($commands[0] === 'routes:clear') {
                $this->routesClear();
            }
        }

        if(count($commands) < 2){
            echo "Uso: php maker make:[controller, model, etc] Nome/do/objeto";
            exit;
        }

        $action = $commands[0]; // objeto a ser criado;
        $action = explode(":", $action);
        $actionName = $action[1];
        $afterTwoDot = ucfirst($actionName);
        $method = $action[0].$afterTwoDot;
        
        

        if(!method_exists($this, $method)){
            echo $method;
            echo "Este método não existe! Exemplos de objetos que podem ser criados:\n
            - make:controller;
            - make:model;
            - make:middleware.
            ";
            exit;
        }

        $nameInput = $commands[1]; // exemplo Usuairos/Usuarios

        $parts = explode("/", $nameInput);
        $className = array_pop($parts); // pegar o último arquivo (que será o .php)
        $className = ucfirst($className);
        $subPath = implode("/", $parts); //subpastas, se houver
        $folder = "app/{$actionName}s/" . $subPath;
        $path = '';

        if($actionName != "view"){
            $path = "{$folder}/{$className}{$afterTwoDot}.php";
        }else{
            $path = "{$folder}/{$className}.php";
        }
  
        $namespace = $subPath ? str_replace('/','\\', $folder): rtrim(str_replace("/", "\\", $folder), "\\");
     
        $classFullName = $className . $afterTwoDot;

        $this->createFile($path, call_user_func_array([$this, $method], [$classFullName, $namespace]), $actionName);

    }

    private function makeController($classFullName, $namespace){
        return <<<PHP
        <?php

        namespace {$namespace};

        use app\core\Controller;
        use app\core\Request;
        use app\core\Response;

        class $classFullName{

            public function index(Request \$req, Response \$res){
                return \$res->send('Hello, World!');
            }

        }

        PHP;

    }   
    
    private function makeService($classFullName, $namespace){
        return <<<PHP
        <?php

        namespace {$namespace};

        use app\core\ServiceResponse;
        use app\core\Model;

        class $classFullName extends Model{

            protected string \$table = '';
            protected array \$columns = [];

            public function __construct(string | null \$env = '')
            {
                \$this->name = \$env;
            }

            public function fetchAll(): ServiceResponse
            {
                return ServiceResponse::success('ok', \$this->all());
            }

        }

        PHP;

    }    

    private function makeMiddleware($classFullName, $namespace){
        return <<<PHP
        <?php

        namespace {$namespace};

    
        use app\contracts\MiddlewareContract;
        use app\services\Response;

        class {$classFullName} implements MiddlewareContract{
            
          
            public function handle(mixed \$data = null): Response | null{
        
                return new Response('ok') ?? null;
            }

        
        }

        PHP;

    } 

    private function routesCache(array $routeFiles){

        if (empty($routeFiles)) {
            echo "⚠️ Nenhum arquivo de rota informado. Exemplo de uso:\n";
            echo "   php cli routes:cache src/routes/web.php src/routes/api.php\n";
            exit;
        }

        foreach ($routeFiles as $file) {
            $filePath = __DIR__ . '/../../' . $file;
            if (!file_exists($filePath)) {
                echo "❌ Arquivo de rota não encontrado: $file\n";
                exit;
            }
            require_once $filePath;
        }

        $cachePath = __DIR__ . '/../../src/cache/routes.php';

        \app\core\Router::cache($cachePath);

        if (file_exists($cachePath)) {
            echo "✅ Cache de rotas gerado com sucesso em: $cachePath\n";
        } else {
            echo "❌ Falha ao gerar o cache de rotas.\n";
        }

        exit;
    }

    private function routesClear(){
        $cachePath = __DIR__ . '/../../src/cache/routes.php';
        if (file_exists($cachePath)) {
            unlink($cachePath);
            echo "🧹 Cache de rotas removido com sucesso.\n";
        } else {
            echo "⚠️ Nenhum cache encontrado para remover.\n";
        }

        exit;
    }

    private function makeView(){
        return <<<PHP
            <h1> Welcome to your new view </h1>
        PHP;

    } 

    private function makeRequest($classFullName, $namespace){
        return <<<PHP
        <?php

        namespace {$namespace};
      
        use app\contracts\RequestValidationContract;
        use app\\requests\RequestValidation;
     

        class $classFullName extends RequestValidation implements RequestValidationContract{

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

        PHP;

    }  

    private function createFile($path, $content, $actionName){

        $dir = dirname($path);

        if(!is_dir($dir)){
            mkdir($dir, 0777, true);
        }

        file_put_contents($path,  $content);

        if(file_exists($path)){
            echo "Arquivo de {$actionName} criado com sucesso.";
            exit;
        }

        echo "Arquivo de {$actionName} não foi criado.";
        exit;

    }
}