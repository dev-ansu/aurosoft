<?php
namespace app\middlewares;

use app\classes\Session;
use app\contracts\MiddlewareContract;
use app\facade\App;
use app\services\acessos\AcessosService;
use app\services\permissoes\PermissoesService;
use app\services\Request;
use app\services\Response;

class RoleMiddleware implements MiddlewareContract{

    public function __construct(private Session $session, private Request $request)
    {
        
    }

    public function handle(mixed $data = null): ?Response{
        $user = App::authSession()->get(SESSION_LOGIN);

        if($user->nivel === 'Administrador'){
            return null;
        }
        $permissoes = (new AcessosService())->all();
        $permissoesByUser = (new PermissoesService())->fetchUsuarioPermissoesByUsuarioWithChave($user->id)->toArray()['data'];
        
        echo "<pre>";
        var_dump($permissoes);
        die;
        return null;
    }

}