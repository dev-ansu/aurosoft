<?php

namespace app\controllers\api;

use app\core\Controller;
use app\requests\acessos\AcessosRequest;
use app\services\acessos\AcessosService;
use app\core\Request;
use app\core\Response;

class AcessosController extends Controller{

    public function __construct(private AcessosService $acessosService)
    {
        
    }

    public function index(Request $req, Response $res){
        $users = $this->acessosService->fetchAll()->data;

  
        $html = <<<HTML
            <table class="table table-hover" id="tabela">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Chave</th>
                        <th>Grupo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
        HTML;

        foreach($users as $user){
            // $user->created_at = (new DateTime($user->created_at))->format('d/m/Y');
            $acessos = [
                'nome_acesso' => $user->nome,
                'chave' => $user->chave,
                'grupo_id' => $user->grupo_id,
                'nome_grupo' => $user->nome_grupo,
                'acesso_id' => $user->id,
                'pagina' => $user->pagina,
            ];
            $editUser = json_encode($acessos);
            extract(json_decode(json_encode($user), true));
  
            $hrefDelete = route("/api/acessos/delete");
            $html.= <<<HTML

                    <tr">
                        <td>{$nome}</td>
                        <td>{$chave}</td>
                        <td>{$nome_grupo}</td>
                        <td>
                            <big>
                                <a href="#" onclick='editarAcessos(`{$editUser}`)' title="Editar dados">
                                    <i class="fa fa-edit text-primary"></i>
                                </a>
                            </big>
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

    public function insert(Request $request, Response $res){

        $validated = $request->post()->validate(AcessosRequest::class);
    

        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => 'Verifique os dados e tente novamente.',
                'issues' => $validated['issues']
            ]);
        }  

        $data = $validated['issues'];

        $response = $this->acessosService->insert($data);

        return $res->json($response->toArray());

    }

    public function patch(Request $request, Response $res){

        $validated = $request->post()->validate(AcessosRequest::class, function($v){
            $v->custom([
                'acesso_id' => 'required|notNull',
                'messages' => [
                    'acesso_id.required' => 'O grupo id é obrigatório.',
                    'acesso_id.notNull' => 'o grupo id não pode ser vazio.',
                ]
            ]);
        });
        
        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => 'Verifique os dados e tente novamente.',
                'issues' => $validated['issues']
            ]);
        }        

    
        $data = $validated['issues'];


        $response = $this->acessosService->patch($data);
   
        return $res->json($response->toArray());
    }

    public function delete(int $id, Response $res){
        
        $response = $this->acessosService->trash('id', $id);
   
        return $res->json($response->toArray());

    }
}
