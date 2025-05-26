<?php
namespace app\controllers\api;

use app\classes\DeniedAcess;
use app\classes\Validate;
use app\core\Controller;
use app\facade\App;
use app\requests\Usuarios\UsuariosValidation;
use app\services\Response;
use app\services\usuarios\UsuariosService;

class UsuariosController extends Controller{


    public function __construct(
        private UsuariosValidation $usuariosValidation, 
        private UsuariosService $usuariosService
    )
    {
        
    }
       
    public function index(): Response{

        $users = $this->usuariosService->fetchAll()->data;

  
        $html = <<<HTML
            <table class="table table-hover" id="tabela">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="esc">Telefone</th>
                        <th class="esc">Email</th>
                        <th class="esc">Nivel</th>
                        <th class="esc">Cadastrado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
        HTML;

        foreach($users as $user){
            $user->created_at = date('d/m/Y', strtotime($user->created_at));
            $editUser = json_encode($user);
            extract(json_decode(json_encode($user), true));
     
            $created_at = date('d/m/Y', strtotime(($created_at)));
            $icone = $ativo === "Sim" ? "fa-check-square":"fa-square-o";
            $titulo_link = $ativo === "Sim" ? "Inativar":"Ativar";
            $classe_ativo = $ativo === "Sim" ? "#c4c4c4":"";
            $hrefDelete = route("/api/usuarios/delete");
            $html.= <<<HTML

                    <tr class="{$classe_ativo}">
                        <td>{$nome}</td>
                        <td>{$telefone}</td>
                        <td>{$email}</td>
                        <td>{$nivel}</td>
                        <td>{$created_at}</td>
                        <td>
                            <big>
                                <a href="#" onclick='editar(`{$editUser}`)' title="Editar dados">
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
                             <big>
                                <a href="#" onclick='mostrar(`{$editUser}`)' title="Mostrar dados">
                                    <i class="fa fa-info-circle text-primary"></i>
                                </a>
                            </big>
                             <big>
                                <a href="#" onclick='ativar("{$id}")' title="{$titulo_link}">
                                    <i class="fa {$icone} text-success"></i>
                                </a>
                            </big>
                             <big>
                                <a href="#" onclick='permissoes("{$id}")' title="Definir permissões">
                                    <i class="fa fa-lock" style="color: blue; margin-left:3px"></i>
                                </a>
                            </big>
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

    public function insert(): Response{

        $this->usuariosValidation->custom([
            'senha' => 'required|notNull',
            'senha_conf' => 'required|notNull',
            'messages' => [
                "senha.required" => "O campo senha é obrigatório.",
                "senha.notNull" => "O campo senha não pode ser vazio.",
                "senha_conf.required" => "O campo confirmar senha é obrigatório.",
                "senha_conf.notNull" => "O campo confirmar senha não pode ser vazio.",
            ]
        ]);
        
        $request = $this->usuariosValidation->validated();

        if(!$request){
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'Verifique os dados e tente novamente.',
                    'issues' => $this->usuariosValidation->getErrors()
                ])
            );
        }        
        $data = $this->usuariosValidation->data();

        if(
            $data['senha'] !== $data['senha_conf'] && !hash_equals($data['senha'], $data['senha_conf'])
        ){
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'As senhas não coincidem.',
                    'issues' => [
                        'senha' => ['notEquals' => 'Senhas não coincidem.'],
                        'senha_conf' => ['notEquals' => 'Senhas não coincidem.']
                    ],
                ])
                );
        }

        $response = $this->usuariosService->insert($data);
   
        return new Response(
            json_encode($response)
        );


    }

    public function patch(){
        
        $this->usuariosValidation->custom([
            'id' => 'required|notNull',
            'senha' => 'optional',
            'senha_conf' => 'optional',
            'messages' => [
                'id.required' => 'O id do usuário é obrigatório.',
                'id.notNull' => 'o id do usuário não pode ser vazio.',
            ]
        ]);

        $request = $this->usuariosValidation->validated();

        if(!$request){
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'Verifique os dados e tente novamente.',
                    'issues' => $this->usuariosValidation->getErrors()
                ])
            );
        }        

        

        $data = $this->usuariosValidation->data();

        if(
            (isset($data['senha']) || isset($data['senha_conf'])) &&

            $data['senha'] !== $data['senha_conf']
        ){
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'As senhas não coincidem.',
                    'issues' => [
                        'senha' => ['notEquals' => 'Senhas não coincidem.'],
                        'senha_conf' => ['notEquals' => 'Senhas não coincidem.']
                    ],
                ])
                );
        }

        $response = $this->usuariosService->patch('id', $data);
   
        return new Response(
            json_encode($response)
        );
    }

    public function delete(int $id): Response{
        $response = $this->usuariosService->trash('id', $id);
   
        return new Response(
            json_encode($response)
        );

    }

    public function activateUser(){
        

    }

}