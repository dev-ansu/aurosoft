<?php

namespace app\controllers\api;

use app\classes\ImageUploader;
use app\core\Request;
use app\core\Response;
use app\facade\App;
use app\requests\Perfil\FotoPerfilRequest;
use app\requests\Perfil\PerfilRequest;
use app\services\Perfil\PerfilService;


class PerfilController{

    public function __construct(private PerfilService $perfilService)
    {
        
    }

    public function index(Request $req, Response $res){

        $validated = $req->post()->validate(PerfilRequest::class);
        
        $validatedImage = $req->file('foto')->validate(FotoPerfilRequest::class);


        if($validatedImage['error']){
            return $res->json([
                'error' => true,
                'message' => 'Verifique os dados e tente novamente.',
                'issues' => $validatedImage['issues']
            ]);
        }


        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => 'Verifique os dados e tente novamente.',
                'issues' => $validated['issues']
            ]);
        }

        $data = $validated['issues'];
        
        if($validatedImage['error'] == false && $validatedImage['issues']['foto'] != null){

            $uploadImage = (new ImageUploader($req->file('foto')->data(), ['jpg', 'jpeg', 'png', 'gif', 'webp'], 2048))->uploadImage();
            
            if($uploadImage['success']){
                
                $data['foto'] = $uploadImage['filename'];
                $data['id'] = App::authSession()->get()->id;
                
                $updated = $this->perfilService->patch('id', $data);
                
                if($updated){
                    
                    $_SESSION[SESSION_LOGIN]->foto = $data['foto'];
                    
                    return $res->json([
                        'error' => false,
                        'message' => 'Perfil atualizado com sucesso.',
                    ]);
                    
                }else{
                    unlink(UPLOAD_DIR . $uploadImage['filename']);
                    return $res->json([
                        'error' => true,
                        'message' => 'O perfil não foi atualizado.',
                    ]);
                }
            }

        }else{
            $data['id'] = App::authSession()->get()->id;
                
            $updated = $this->perfilService->patch('id', $data);
            
            if($updated){
                                
                return $res->json([
                    'error' => false,
                    'message' => 'Perfil atualizado com sucesso.',
                ]);
                
            }else{
                return $res->json([
                    'error' => true,
                    'message' => 'O perfil não foi atualizado.',
                ]);
            }
            
        }

        return $res->json([
                'error' => true,
                'message' => 'Ocorreu um erro na hora realizar a atualização do perfil.',
            ]);
        
    }

}
