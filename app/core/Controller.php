<?php

namespace app\core;

use Exception;

class Controller{
    
    public function load(string $viewName, array $viewData = []){
        try{
            
            // Validação do caminho da view
            $viewPath = realpath(VIEWS_PATH . $viewName . ".php");
            $viewsDir = realpath(VIEWS_PATH);
          
            if(strpos($viewPath, $viewsDir) !== 0 || !file_exists($viewPath)){
                throw new Exception('View não encontrada');
            }

         
            $safeData = array_map(function($item){
                return is_string($item) ? escape($item): $item;
            }, $viewData);
            
               
            extract($safeData);
       
            include $viewPath;

        }catch(Exception $e){
            
             // Log do erro em produção
            error_log($e->getMessage());
            echo $e->getMessage();
            // Mensagem genérica em produção
            echo "Ocorreu um erro ao carregar a página.";

        }
        
    }


    /**
     * Nega o acesso de um usuário
     * @param string $key - chave da mensagem
     * @param string $message - mensagem para o usuário
     * @param string $to - url de redirecionamento
     */
  
}