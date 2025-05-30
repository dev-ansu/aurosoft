<?php
namespace app\middlewares;

use app\classes\Session;
use app\contracts\MiddlewareContract;
use app\facade\App;
use app\services\acessos\AcessosService;
use app\services\PermissionService;
use app\services\permissoes\PermissoesService;
use app\services\Request;
use app\services\Response;

class RoleMiddleware implements MiddlewareContract{

    public function __construct(private Request $request)
    {
        
    }

    public function handle(?Request $req, ?Response $res){
        $user = App::authSession()->get();

        // Se for administrador, permite tudo
        if ($user->nivel === 'Administrador') {
            return null;
        }

        // Obter a última parte da URI
        $uriPath = parse_url($this->request->getServer('REQUEST_URI'), PHP_URL_PATH);
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
            return $res->redirect($this->request->getServer('HTTP_REFERER') ?? '/');

        }

        return null;
    }

}