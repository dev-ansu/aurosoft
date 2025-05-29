<?php

namespace app\controllers;

use app\core\Controller;
use app\requests\TesteRequest;
use app\services\Request;
use app\services\Response;

class TesteController extends Controller{

    public function index(Request $request): Response{
        
    
        $req = $request->get()->validate(TesteRequest::class,function($v){
            $v->custom([
                'senha' => 'required',
                'messages' => [
                    'senha.required' => "Senha obrigatória."
                ]
                ]);
        });
        
 
        return new Response(
            'Hello world!'
        );
    }

}
