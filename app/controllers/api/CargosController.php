<?php

namespace app\controllers\api;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\requests\Cargos\CargosRequest;
use app\services\Cargos\CargosService;
use app\services\PermissionService;

class CargosController{

    public function __construct(
        private CargosService $cargosService,
    )
    {
        
    }

    public function index(Request $req, Response $res){
        
        $cargos = $this->cargosService->fetchAll()->toArray()['data'];

  
        $html = <<<HTML
            <table class="table table-hover" id="tabela">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
        HTML;

        foreach($cargos as $cargo){
            $editCargo = json_encode($cargo);
            extract(json_decode(json_encode($cargo), true));

            $botoes = '';

            if(PermissionService::has('api/cargos/patch')){
                $botoes.=<<<HTML
                     <big>
                    <a href="#" onclick='editarCargos(`{$editCargo}`)' title="Editar dados">
                        <i class="fa fa-edit text-primary"></i>
                    </a>
                </big>
                HTML;
            }

            $permissoesButton = null;
        
            if((PermissionService::has('api/permissoes'))){
                $permissoesButton = <<<HTML
                <big>
                    <a href="#" onclick='definirPermissoes("{$id}", "{$nome}")' title="Definir permissões">
                        <i class="fa fa-lock" style="color: blue; margin-left:3px"></i>
                    </a>
                </big>
                HTML;
            }
            
            
            if(PermissionService::has('api/cargos/delete')){   
                $hrefDelete = route("/api/cargos/delete");
                $botoes.=<<<HTML
                    <li class="dropdown head-dpdn2 cursor-pointer" style="display: inline-block;">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <big>
                                <i class="fa fa-trash-o text-danger"></i>
                            </big>
                        </a>
                        <ul class="dropdown-menu cursor-pointer" style="margin-left:-230px">
                            <li>
                                <div>
                                    <p>
                                        Confirmar exclusão? 
                                        <a href="#" onclick="onDelete(`{$hrefDelete}/{$id}`)">
                                            <span class="text-danger">Sim</span>
                                        </a>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </li>
                HTML;
            }

            $html.= <<<HTML

                    <tr">
                        <td>{$id}</td>
                        <td>{$nome}</td>
                        <td>
                            {$botoes}
                            {$permissoesButton}
                        </td>
                    </tr>
                HTML;

        }
        $assetsPath = ASSETS_PATH;
        $html.= <<<HTML
            </tbody>
            <div id="mensagem-excluir" class="alert alert-danger d-flex justify-content-between" >
                <span></span>
                <span>X</span>
            </div>
                
            </table>
            <script type="text/javascript">
                $(document).ready( ()=> {
                    const table = new DataTable("#tabela", {
                        language: {
                            url: "$assetsPath/js/pt-BR.js",
                        },
                        ordering: false,
                        stateSave: true
                    })
                
                })
            </script>
        HTML;
        
        return $res->send($html);
    }
    
    public function insert(Request $req, Response $res){
        $request = $req->post()->validate(CargosRequest::class);

        if($request['error'] == true){
            return $res->json([
                'error' => true,
                'message' => 'Verifique os dados e tente novamente.',
                'issues' => $request['issues']
            ]);
        }

        
        $data = $request['issues'];
        
        $response = $this->cargosService->insert($data);
        
        return $res->json($response->toArray());
    }

    public function delete(int $id, Response $res){
        
        if($id === 1 || $id === 2){
            $response = $this->cargosService->find('id', $id);
            if(strtolower($response->nome) === "cliente" || strtolower($response->nome) === 'administrador'){
                return $res->json([
                    'error' => true,
                    'message' => "Não é possível excluir os cargos padrões."
                ]);
                exit;
            }
            return $res->json([
                'error' => true,
                'message' => "Não é possível excluir os cargos padrões."
            ]);
            exit;
        }

        $response = $this->cargosService->trash('id', $id);
        
        return $res->json($response->toArray());
    }
    
}
