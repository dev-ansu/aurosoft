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
        
       
        
 
        // Verifica permissão
        if (!PermissionService::has($uri)) {
            
            if(App::request()->isAjax()){
                $res->send('Você não tem permissão para realizar esta ação.', [], 403);
                exit;
            }
            
            setFlash('message', 'Você não tem permissão para realizar esta ação.');
            $res->redirect($req->getServer('HTTP_REFERER') ?? '/');
            exit;

        }

        return null;
    }

}