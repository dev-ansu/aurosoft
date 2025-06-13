<?php
namespace app\controllers\api;

use app\core\Controller;
use app\requests\Usuarios\UsuariosValidation;
use app\services\PermissionService;
use app\core\Request;
use app\core\Response;
use app\services\Usuarios\UsuariosService;
use DateTime;

class UsuariosController extends Controller{


    public function __construct(
        private UsuariosService $usuariosService
    )

    {
        
    }
       
    public function index(Request $req, Response $res){

        $users = $this->usuariosService->fetchAll()->data;

  
        $html = <<<HTML
            <table class="table table-hover" id="tabela">
                <input type="hidden" id="ids">
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
            $user->created_at = (new DateTime($user->created_at))->format('d/m/Y');
            $editUser = json_encode($user);
            extract(json_decode(json_encode($user), true));
            $urlAtivar = $ativo === "Sim" ? route("/api/usuarios/deactivate/$id"):route("/api/usuarios/activate/$id");
            $icone = $ativo === "Sim" ? "fa-check-square":"fa-square-o";
            $titulo_link = $ativo === "Sim" ? "Inativar":"Ativar";
            $classe_ativo = $ativo === "Sim" ? "#c4c4c4":"";
            $hrefDelete = route("/api/usuarios/delete");
            
            if($user->cargo_nome !== "Administrador"){
                if((PermissionService::has('api/permissoes'))){
                    $permissoesButton = <<<HTML
                    <big>
                        <a href="#" onclick='definirPermissoes("{$id}", "{$nome}")' title="Definir permissões">
                            <i class="fa fa-lock" style="color: blue; margin-left:3px"></i>
                        </a>
                    </big>
                    HTML;
                }
            }else{
                $permissoesButton = '';
            }
            $botoes = null;


            if(PermissionService::has('api/usuarios/patch')){
                $botoes.= <<<HTML
                    <big>
                        <a href="#" onclick='editar(`{$editUser}`)' title="Editar dados">
                            <i class="fa fa-edit text-primary"></i>
                        </a>
                    </big>
                HTML;
            }
            if(PermissionService::has('dashboard/usuarios')){
                $botoes.= <<<HTML
                    <big>
                        <a href="#" onclick='mostrar(`{$editUser}`)' title="Mostrar dados">
                            <i class="fa fa-info-circle text-primary"></i>
                        </a>
                    </big>
                HTML;
            }

            if(PermissionService::has('api/usuarios/delete')){
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

            if(PermissionService::has("api/usuarios/activate") || PermissionService::has("api/usuarios/deactivate")){
                $botoes.=<<<HTML
                     <big>
                        <a href="#" onclick='ativar(`{$urlAtivar}`)' title="{$titulo_link}">
                            <i class="fa {$icone} text-success"></i>
                        </a>
                    </big>
                HTML;
            }
            

            $html.= <<<HTML

                    <tr class="{$classe_ativo}">
                        <td>
                        <input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar(`{$id}`)">
                        {$nome}
                        </td>
                        <td>{$telefone}</td>
                        <td>{$email}</td>
                        <td>{$cargo_nome}</td>
                        <td>{$created_at}</td>
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

                function selecionar(id){

                    var ids = $('#ids').val();

                    if($('#seletor-'+id).is(":checked") == true){
                        var novo_id = ids + id + '-';
                        $('#ids').val(novo_id);
                    }else{
                        var retirar = ids.replace(id + '-', '');
                        $('#ids').val(retirar);
                    }

                    var ids_final = $('#ids').val();
                    console.log(ids_final);
                    if(ids_final == ""){
                        $('#btn-deletar').hide();
                    }else{
                        $('#btn-deletar').show();
                    }
            }

            function deletarSel(){
                var ids = $('#ids').val();
                var id = ids.split("-");
                
                for(i=0; i<id.length-1; i++){
                    excluir(id[i]);			
                }

                limparCampos();
            }


            function excluir(id){	
                $('#mensagem-excluir').text('Excluindo...')
                
                $.ajax({
                    url: "/api/usuarios/delete/" + id,
                    method: 'GET',
                    dataType: "json",
                    success:function(result){
                        const response = JSON.parse(result);
                        if (!response.error) {            	
                            listar();
                            $('#mensagem-excluir').hide()
                        } else {
                            $('#mensagem-excluir').addClass('text-danger')
                            $('#mensagem-excluir').text(response.message)
                            $('#mensagem-excluir').show()
                        }
                    },
                    error(xhr, status, error){
                        $('#mensagem-excluir').text(xhr.responseText)
                        $('#mensagem-excluir').show()
                    }
                });
            }

            </script>
        HTML;
        
        return $res->send($html);
    }

    public function insert(Request $request, Response $res){

   
        $validated = $request->post()->validate(UsuariosValidation::class, function($v){
            $v->custom([
            'senha' => 'required|notNull',
            'senha_conf' => 'required|notNull',
            'messages' => [
                "senha.required" => "O campo senha é obrigatório.",
                "senha.notNull" => "O campo senha não pode ser vazio.",
                "senha_conf.required" => "O campo confirmar senha é obrigatório.",
                "senha_conf.notNull" => "O campo confirmar senha não pode ser vazio.",
            ]
            ]);
        });
        
       
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

        if(
            $data['senha'] !== $data['senha_conf'] && !hash_equals($data['senha'], $data['senha_conf'])
        ){
            return $res->json(
                    [
                    'error' => true,
                    'message' => 'As senhas não coincidem.',
                    'issues' => [
                        'senha' => ['notEquals' => 'Senhas não coincidem.'],
                        'senha_conf' => ['notEquals' => 'Senhas não coincidem.']
                    ]]
                );
        }

        $response = $this->usuariosService->insert($data);
   
        return $res->json($response->toArray());

    }

    public function patch(Request $request, Response $res){

        $validated = $request->post()->validate(UsuariosValidation::class, function($v){
            $v->custom([
                'id' => 'required|notNull',
                'senha' => 'optional',
                'senha_conf' => 'optional',
                'messages' => [
                    'id.required' => 'O id do usuário é obrigatório.',
                    'id.notNull' => 'o id do usuário não pode ser vazio.',
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

        if(
            (isset($data['senha']) || isset($data['senha_conf'])) &&

            $data['senha'] !== $data['senha_conf']
        ){
            return $res->json([
                'error' => true,
                'message' => 'As senhas não coincidem.',
                'issues' => [
                    'senha' => ['notEquals' => 'Senhas não coincidem.'],
                    'senha_conf' => ['notEquals' => 'Senhas não coincidem.']
                ],
            ]);
        }

        $response = $this->usuariosService->patch('id', $data);

        return $res->json($response->toArray());
    }

    public function delete(int $id, Response $res){

        $response = $this->usuariosService->trash('id', $id);
   
        return $res->json($response->toArray());

    }

    public function activate(int $id, Response $res){
        $response = $this->usuariosService->activate('id', $id);
   
        return $res->json($response->toArray());
    }

    public function deactivate(int $id, Response $res){
        $response = $this->usuariosService->deactivate('id', $id);
   
        return $res->json($response->toArray());

    }

    
}