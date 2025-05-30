<?php
namespace app\middlewares;


use app\facade\App;
use app\core\Request;
use app\core\Response;
use app\services\PermissionService;


class RoleMiddleware{

   
    public function handle(Request $req, Response $res){
        $user = App::authSession()->get();

        // Se for administrador, permite tudo
        if ($user->nivel === 'Administrador') {
            return null;
        }

        // Obter a última parte da URI
        $uriPath = parse_url($req->getServer('REQUEST_URI'), PHP_URL_PATH);
        $uriParts = array_filter(explode('/', trim($uriPath, '/')));
        $uri = implode("/", $uriParts);
       
        
        if(count($uriParts) > 1){    
            array_shift($uriParts);
            $uri = implode("/", $uriParts); 
        }
 
        // Verifica permissão
        if (!PermissionService::has($uri)) {
            
            if(App::request()->isAjax()){
                return $res->send('Você não tem permissão para realizar esta ação.', [], 403);
            }
            setFlash('message', 'Você não tem permissão para realizar esta ação.');
            return $res->redirect($req->getServer('HTTP_REFERER') ?? '/');

        }

        return null;
    }

}