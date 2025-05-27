<?php
namespace app\middlewares;

use app\classes\Session;
use app\services\Redirect;
use app\services\Request;
use app\services\Response;

class AuthMiddleware{

    public function __construct(private Session $session, private Request $request)
    {
        
    }

    public function handle(): ?Response{
        // Verifica se a sessão possui o índice SESSION_LOGIN
        if(!$this->session->has(SESSION_LOGIN) || empty($this->session->__get(SESSION_LOGIN))){
            if($this->request->isAjax()){
                return new Response(
                    'Não autorizado',
                    403
                );
            }else{
                setFlash('message', 'Não autorizado');
                return new Redirect('/', 403);
            }

        } 

        return null;
    }

}