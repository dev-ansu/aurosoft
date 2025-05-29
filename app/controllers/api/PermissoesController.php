<?php

namespace app\controllers\api;

use app\core\Controller;
use app\requests\InserirPermissoes\InserirPermissoes;
use app\requests\permissoes\PermissoesRequest;
use app\services\acessos\AcessosService;
use app\services\GrupoAcessos\GrupoAcessosService;
use app\services\permissoes\PermissoesService;
use app\services\Response;

class PermissoesController extends Controller{


    public function __construct(
        private PermissoesRequest $permissoesRequest, 
        private PermissoesService $permissoesService,
        private GrupoAcessosService $grupoAcessosService,
        private AcessosService $acessosService
        )
    {
        
    }

    public function index(): Response{

        $request = $this->permissoesRequest->validated();
        
        if(!$request){
            return new Response(
                'Verifique os dados e tente novamente.',
            );
        }
        
        $data = $this->permissoesRequest->data();
        $id_usuario = $data['id'];
        $permissoes = $this->permissoesService->fetchPermissoesSemGrupo(0)->toArray();
        $permissoesData = $permissoes['data'];
     
        $span = null;
        if(count($permissoesData) > 0){
            $span = <<<HTML
                <span class="titulo-grupo">
                    <b>Sem grupo</b>
                </span>
            HTML;
            $span.= "<div class='row'>";
            foreach($permissoesData as $permissao){
                $res = $this->permissoesService->fetchUsuarioPermissoes($id_usuario, $permissao->id)->toArray()['data'];
                if(count($res) > 0){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }

                $span.= <<<HTML
                    <div class="form-check col-md-3">
                        <input class="form-check-input" type="checkbox" value="" id="{$permissao->id}" $checked onclick="adicionarPermissao($permissao->id, $id_usuario)"  />
                        <label style="font-size:13px" for="{$permissao->id}" class="labelcheck">$permissao->nome</label>
                    </div>
                HTML;
            }
            $span.= "</div><hr>";
        }

        $allGrupos = $this->grupoAcessosService->fetchAllGrupos()->toArray();
        $gruposData = json_decode(json_encode($allGrupos['data']), true);
        
        if(count($gruposData) > 0){
            
            foreach($gruposData as $grupo){
                $grupo_id = $grupo['id'];
                $grupo_nome = $grupo['nome'];
                    $span.= <<<HTML
                    <span class="titulo-grupo">
                        <b>$grupo_nome</b>
                    </span>
                HTML;
                $span.= "<div class='row'>";

                $res = $this->acessosService->acessoByGrupo($grupo_id)->toArray();
                $resData = json_decode(json_encode($res['data']), true);
                
                
                
                foreach($resData as $acesso){
                    $acesso_id = $acesso['id'];
                    $acesso_nome = $acesso['nome'];
                    $permissoesChecked = $this->permissoesService->fetchUsuarioPermissoes($id_usuario, $acesso_id)->toArray()['data'];
                  
                    if(count($permissoesChecked) > 0){
                        $checked2 = 'checked';
                    }else{
                        $checked2 = '';
                    }

                    
                    $span.= <<<HTML
                    <div class="form-check col-md-3">
                        <input class="form-check-input" type="checkbox" value="" id="{$acesso_id}" $checked2 onclick="adicionarPermissao($acesso_id, $id_usuario)"  />
                        <label style="font-size:13px" for="{$acesso_id}" class="labelcheck">$acesso_nome</label>
                    </div>
                    HTML;
                }
                $span.= "</div><hr>";
            }
        }
        // echo "<pre>";
        // var_dump($permissoesData);




        return new Response(
            $span
        );
    }


    public function insert(): Response{

        $request =  new InserirPermissoes;
        $inserirPermissoes = $request->validated();

        if(!$inserirPermissoes){
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'Verifique os dados e tente novamente.',
                    'issues' => $request->getErrors()
                ])
            );
        }

        $data = $inserirPermissoes->data();
        $response = $this->permissoesService->insert([
            'usuario_id' => $data['usuario_id'],
            'permissao' => $data['permissao_id']
        ]);
        
        return new Response(json_encode($response));
    }

    public function insertAll(): Response{

        $request =  new InserirPermissoes;
        
        $inserirPermissoes = $request->validate([
            'usuario_id' => 'required|notNull',
        ]);

        if(!$inserirPermissoes){
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'Verifique os dados e tente novamente.',
                    'issues' => $request->getErrors()
                ])
            );
        }

        $data = $inserirPermissoes['usuario_id'];

        $response = $this->permissoesService->insertAllPermissoes($data);
        
        return new Response(json_encode($response));
    }

}
