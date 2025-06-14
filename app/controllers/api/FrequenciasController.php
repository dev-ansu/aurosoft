<?php

namespace app\controllers\api;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\requests\Frequencias\FrequenciasRequest;
use app\services\Frequencias\FrequenciasService;
use app\services\PermissionService;

class FrequenciasController{

    public function __construct(private FrequenciasService $frequenciasService)
    {
        
    }

    public function index(Request $req, Response $res){
        $frequencias = $this->frequenciasService->fetchAll()->data;

  
        $html = <<<HTML
            <table class="table table-hover" id="tabela">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Taxa</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
        HTML;

        foreach($frequencias as $frequencia){
            // $frequencia->created_at = (new DateTime($frequencia->created_at))->format('d/m/Y');
            $formas = [
                'id_frequencia' => $frequencia->id,
                'nome_frequencia' => $frequencia->frequencia,
                'dias' => $frequencia->dias,
            ];
            $editUser = json_encode($formas);
            extract(json_decode(json_encode($frequencia), true));
  
            $hrefDelete = route("/api/frequencias/delete");
            $botoes = null;

            if(PermissionService::has("api/frequencias/patch")){
                $botoes.= <<<HTML
                    <big>
                        <a href="#" onclick='editarFrequencia(`{$editUser}`)' title="Editar dados">
                            <i class="fa fa-edit text-primary"></i>
                        </a>
                    </big>
                HTML;
            }
            if(PermissionService::has("api/frequencias/delete")){
                $botoes.= <<<HTML
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
                        <td>{$frequencia}</td>
                        <td>{$dias}</td>
                        <td>
                            {$botoes}
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

        $validated = $req->post()->validate(FrequenciasRequest::class);

        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => "Verifique os dados e tente novamente.",
                'issues' => $validated['issues'],
            ]);
        }


        $data = $validated['issues'];

        $response = $this->frequenciasService->insert($data);

        return $res->json($response->toArray());
    }


    public function delete(int $id, Response $res){

        $response = $this->frequenciasService->trash('id', $id);
   
        return $res->json($response->toArray());

    }

    public function patch(Request $request, Response $res){

        $validated = $request->post()->validate(FrequenciasRequest::class, function($v){
            $v->custom([
                'id_frequencia' => 'required|notNull',
                'messages' => [
                    'id_frequencia.required' => 'O id da frequência é obrigatório.',
                    'id_frequencia.notNull' => 'o id da frequência não pode ser vazio.',
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


        $response = $this->frequenciasService->patch($data);

        return $res->json($response->toArray());
    }

}
