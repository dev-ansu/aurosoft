<?php

namespace app\controllers\api;

use app\core\Controller;
use app\requests\GrupoAcessos\GrupoAcessosRequest;
use app\services\GrupoAcessos\GrupoAcessosService;
use app\services\Request;
use app\services\Response;
use DateTime;

class GrupoAcessosController extends Controller{

    // public function middlewareMap(): array
    // {
    //     $session = (new Session)->__get(SESSION_LOGIN);
        
    //     return [
    //         'index' => [
    //             AuthMIddleware::class,
    //             [RoleMiddleware::class, [$session->nivel ?? null]]
    //         ],
    //     ];
    // }
    
    public function __construct(
        private GrupoAcessosService $grupoAcessoService, 
        private GrupoAcessosRequest $grupoAcessosRequest
        
        )
    {
        
    }

    public function index(): Response{
  
        $users = $this->grupoAcessoService->fetchAll()->data;

  
        $html = <<<HTML
            <table class="table table-hover" id="tabela">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Qtd. Acessos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
        HTML;

        foreach($users as $user){
            // $user->created_at = (new DateTime($user->created_at))->format('d/m/Y');
            $grupo = [
                'grupo_id' => $user->id,
                'nome_grupo' => $user->nome,

            ];
            $editUser = json_encode($grupo);
            extract(json_decode(json_encode($user), true));
  
            $hrefDelete = route("/api/grupoacessos/delete");
            $html.= <<<HTML

                    <tr">
                        <td>{$nome}</td>
                        <td>{$QtdAcessos}</td>
                        <td>
                            <big>
                                <a href="#" onclick='editarGrupo(`{$editUser}`)' title="Editar dados">
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
        
        return new Response(
            $html,
        );
    }

    public function insert(Request $request): Response{
        
        $validated = $request->post()->validate(GrupoAcessosRequest::class);


        if($validated['error']){
            
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'Verifique os dados e tente novamente.',
                    'issues' => $validated['issues']
                ])
            );

        }

        $response = $this->grupoAcessoService->insert($validated['issues']);


        return new Response(json_encode($response));
    }

    public function delete(int $id): Response{
        $response = $this->grupoAcessoService->trash('id', $id);
   
        return new Response(
            json_encode($response)
        );

    }


    public function patch(Request $request){

        $validated = $request->post()->validate(GrupoAcessosRequest::class, function($v){
            $v->custom([
                'grupo_id' => 'required|notNull',
                'messages' => [
                    'grupo_id.required' => 'O grupo id é obrigatório.',
                    'grupo_id.notNull' => 'o grupo id não pode ser vazio.',
                ]
                ]);
        });
  

        if($validated['error']){
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'Verifique os dados e tente novamente.',
                    'issues' => $validated['issues']
                ])
            );
        }        

        

        $data = $validated['issues'];


        $response = $this->grupoAcessoService->patch($data);
   
        return new Response(
            json_encode($response)
        );
    }
    
}