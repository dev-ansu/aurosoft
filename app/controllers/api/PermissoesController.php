<?php

namespace app\controllers\api;

use app\core\Controller;
use app\facade\App;
use app\requests\InserirPermissoes\InserirPermissoes;
use app\requests\Permissoes\PermissoesRequest;
use app\services\Acessos\AcessosService;
use app\services\GrupoAcessos\GrupoAcessosService;
use app\services\Permissoes\PermissoesService;
use app\core\Request;
use app\core\Response;
use app\services\PermissionService;

class PermissoesController extends Controller{


    public function __construct(
        private PermissoesRequest $permissoesRequest, 
        private PermissoesService $permissoesService,
        private GrupoAcessosService $grupoAcessosService,
        private AcessosService $acessosService
        )
    {
        
    }

    public function index(Request $req, Response $res){

        $request = App::request()->post()->validate(PermissoesRequest::class);
        
        if($request['error']){
            return $res->send('Verifique os dados e tente novamente.');     
        }
        
        $data = $request['issues'];
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
                $response = $this->permissoesService->fetchUsuarioPermissoes($id_usuario, $permissao->id)->toArray()['data'];
                if(count($response) > 0){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $inputCheckbox = null;
                
                if(PermissionService::has("permissoes/insert")){
                    $inputCheckbox = <<<HTML
                        <input class="form-check-input" type="checkbox" value="" id="{$permissao->id}" $checked onclick="adicionarPermissao($permissao->id, $id_usuario)"  />
                    HTML;
                }

                $span.= <<<HTML
                    <div class="form-check col-md-4 gap-2">
                        {$inputCheckbox}
                        <label style="font-size:14px" for="{$permissao->id}" class="labelcheck">$permissao->nome</label>
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

                $response = $this->acessosService->acessoByGrupo($grupo_id)->toArray();
                $responseData = json_decode(json_encode($response['data']), true);
                
                
                
                foreach($responseData as $acesso){
                    $acesso_id = $acesso['id'];
                    $acesso_nome = $acesso['nome'];
                    $permissoesChecked = $this->permissoesService->fetchUsuarioPermissoes($id_usuario, $acesso_id)->toArray()['data'];
                  
                    if(count($permissoesChecked) > 0){
                        $checked2 = 'checked';
                    }else{
                        $checked2 = '';
                    }

                    $inputCheckbox = null;
                
                    if(PermissionService::has("permissoes/insert")){
                        $inputCheckbox = <<<HTML
                            <input class="form-check-input" type="checkbox" value="" id="{$acesso_id}" $checked2 onclick="adicionarPermissao($acesso_id, $id_usuario)"  />
                        HTML;
                    }
                    $span.= <<<HTML
                    <div class="form-check col gap-2">
                        {$inputCheckbox}
                        <label style="font-size:14px" for="{$acesso_id}" class="labelcheck">$acesso_nome</label>
                    </div>
                    HTML;
                }
                $span.= "</div><hr>";
            }
        }
       
        
        
        return $res->send($span);
    }


    public function insert(Request $request, Response $res){
        
        $validated = $request->post()->validate(InserirPermissoes::class);

    
        if($validated['error']){
            return $res->json(
                [
                    'error' => true,
                    'message' => 'Verifique os dados e tente novamente.',
                    'issues' => $validated['issues']
                ]
                );
        }

        $data = $validated['issues'];
        $response = $this->permissoesService->insert([
            'cargo_id' => $data['cargo_id'],
            'permissao' => $data['permissao_id']
        ]);
        
        return $res->json($response->toArray());
    }


}
