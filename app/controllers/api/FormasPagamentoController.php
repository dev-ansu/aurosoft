<?php

namespace app\controllers\api;

use app\core\Request;
use app\core\Response;
use app\requests\FormasPagamento\FormasPagamentoRequest;
use app\services\FormasPagamento\FormasPagamentoService;
use app\services\PermissionService;

class FormasPagamentoController{

    public function __construct(private FormasPagamentoService $formasPagamentoService)
    {
        
    }

    public function index(Request $req, Response $res){
        $formas_pagamento = $this->formasPagamentoService->fetchAll()->data;

  
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

        foreach($formas_pagamento as $forma_pagamento){
            // $forma_pagamento->created_at = (new DateTime($forma_pagamento->created_at))->format('d/m/Y');
            $formas = [
                'id_forma_pagamento' => $forma_pagamento->id,
                'nome_forma_pagamento' => $forma_pagamento->nome,
                'taxa' => $forma_pagamento->taxa,
            ];
            $editUser = json_encode($formas);
            extract(json_decode(json_encode($forma_pagamento), true));

            $botoes = null;
            $hrefDelete = route("/api/formaspagamento/delete");

            if(PermissionService::has('api/formaspagamento/patch')){
                $botoes.= <<<HTML
                    <big>
                        <a href="#" onclick='editarFormaPagamento(`{$editUser}`)' title="Editar dados">
                            <i class="fa fa-edit text-primary"></i>
                        </a>
                    </big>
                HTML;
            }

            if(PermissionService::has('api/formaspagamento/delete')){
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
                        <td>{$nome}</td>
                        <td>{$taxa}</td>
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

        $validated = $req->post()->validate(FormasPagamentoRequest::class);

        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => "Verifique os dados e tente novamente.",
                'issues' => $validated['issues'],
            ]);
        }


        $data = $validated['issues'];

        $response = $this->formasPagamentoService->insert($data);

        return $res->json($response->toArray());
    }


    public function delete(int $id, Response $res){

        $response = $this->formasPagamentoService->trash('id', $id);
   
        return $res->json($response->toArray());

    }

    public function patch(Request $request, Response $res){

        $validated = $request->post()->validate(FormasPagamentoRequest::class, function($v){
            $v->custom([
                'id_forma_pagamento' => 'required|notNull',
                'messages' => [
                    'id_forma_pagamento.required' => 'O id da forma de pagamento é obrigatório.',
                    'id_forma_pagamento.notNull' => 'o id da forma de pagamento não pode ser vazio.',
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


        $response = $this->formasPagamentoService->patch($data);

        return $res->json($response->toArray());
    }

}
