<?php

namespace app\controllers\api;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\requests\recuperarsenha\RecuperarSenhaRequest;
use app\services\recuperarsenha\RecuperarSenhaService;

class RecuperarSenhaController{

    public function __construct(private RecuperarSenhaService $recuperarSenhaService)
    {
        
    }

    public function index(Request $req, Response $res){

        $validated = $req->post()->validate(RecuperarSenhaRequest::class);

        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => 'Verifique os dados e tente novamente.',
                'issues' => $validated['issues'],
            ]);
        }
        
        $data = $validated['issues'];

        $response = $this->recuperarSenhaService->recuperarSenha($data);

        $res->json($response->toArray());
        return;
    }

}
