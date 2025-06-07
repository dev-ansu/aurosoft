<?php

namespace app\controllers\api;

use DateTime;
use Exception;
use Throwable;
use app\facade\App;
use app\core\Request;
use app\core\Response;
use app\core\Controller;

use app\classes\FileUploader;
use app\classes\ImageUploader;
use app\classes\Validate;
use app\services\PermissionService;
use app\requests\ContasReceber\ContasReceberRequest;
use app\services\ContasReceber\ContasReceberService;
use app\requests\ContasReceber\ContasReceberFiltroRequest;
use app\requests\ContasReceber\ContasReceberArquivoRequest;

class ContasReceberController{


    public function __construct(private ContasReceberService $contasReceberService)
    {
        
    }

    public function index(Request $req, Response $res){

        $dados = $req->get()->validate(ContasReceberFiltroRequest::class);

   
        $contas_receber = $this->contasReceberService->fetchAll()->data;

        
        
        if($dados['error'] == false){
            $issues = $dados['issues'];
            $contas_receber = $this->contasReceberService->fetchBetween($issues['data_ini'], $issues['data_fim'])->data;
            $situacao = $issues['situacao'];

            if($situacao){
                switch ($situacao){
                    case 'at':
                        $contas_receber = $this->contasReceberService->fetchAtrasadas($issues['data_ini'], $issues['data_fim'], (new DateTime())->format('Y-m-d'))->data;
                        break;  
                    case 'ab':
                        $contas_receber = $this->contasReceberService->fetchAbertas($issues['data_ini'], $issues['data_fim'], (new DateTime())->format('Y-m-d'))->data;
                        break;                                      
                    case 'pg':
                        $contas_receber = $this->contasReceberService->fetchConfirmadas($issues['data_ini'], $issues['data_fim'])->data;
                        break;                                      
                }
            }
        }

        $situacao = (new Validate)->validate([
            'situacao' => 'optional|patternValues:[ab,at,pg]',
        ]);

        if($situacao && $dados['error'] == true){
            switch ($situacao['situacao']){
                case 'at':
                    $contas_receber = $this->contasReceberService->fetchAllAtrasadas()->data;
                    break;  
                case 'ab':
                    $contas_receber = $this->contasReceberService->fetchAllAbertas()->data;
                    break;                                      
                case 'pg':
                    $contas_receber = $this->contasReceberService->fetchAllConfirmadas()->data;
                    break;                                      
                }
        }


  
        $html = <<<HTML
                <input type="hidden" id="ids">
            <table class="table table-hover" id="tabela">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Cliente</th>
                        <th>Vencimento</th>
                        <th>Pagamento</th>
                        <th>Data de lançamento</th>
                        <th>Forma de pagamento</th>
                        <th>Frequência</th>
                        <th>Observação</th>
                        <th>Arquivo</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
        HTML;

        $data_ini_mes = (new DateTime('first day of this month'))->format('Y-m-d');
        $data_fim_mes = (new DateTime('last day of this month'))->format('Y-m-d');

        foreach($contas_receber as $conta_receber){
            // $conta_receber->created_at = (new DateTime($conta_receber->created_at))->format('d/m/Y');
            extract(json_decode(json_encode($conta_receber), true));
            
            $botoes = null;
            $hrefDelete = route("/api/contasreceber/delete");
            $valor = "R$ " . number_format($valor, 2, ',', '.');
            $descricao = $descricao ?? "Sem descrição";
            $cliente = $cliente ?? "Sem cliente";
            $data_lanc = (new DateTime($data_lanc))->format('d/m/Y');
            if($data_pgto){
                    $data_pgto = (new DateTime($data_pgto))->format('d/m/Y');
                }
            
            $data_atual = (new DateTime())->format('Y-m-d');
            $situacao = $pago == 1 ? "Confirmado":($pago == 0 & $data_atual > $vencimento ? 'Vencido':'Em aberto');
            $conta_receber->situacao = $situacao;
            $editUser = json_encode($conta_receber);
            
            $classSituacao = $situacao == "Confirmado" ? "bg-success":($situacao == "Vencido" ? "bg-danger":"bg-info"  );
            $vencimento = (new DateTime($vencimento))->format('d/m/Y');
            
     
            $link = UPLOADS_PATH . "/".$arquivo;
            
            if($arquivo){
                $exploded = explode(".", $arquivo);
                $extensao = array_pop($exploded);

                if(in_array($extensao, ['jpg', 'jpeg', 'png', 'webp', 'jiff'])){
                    $arquivo = uploaded("/$arquivo");
                }else{
                    $arquivo = asset("/icones/{$extensao}.png");
                }
                
            }

           if(PermissionService::has('dashboard/contasreceber')){
                $botoes.= <<<HTML
                    <big>
                        <a href="#" onclick='mostrar(`{$editUser}`)' title="Mostrar dados">
                            <i class="fa fa-info-circle text-primary"></i>
                        </a>
                    </big>
                HTML;
            }

            if(PermissionService::has('api/contasreceber/patch')){
                $botoes.= <<<HTML
                    <big>
                        <a href="#" onclick='editarContaReceber(`{$editUser}`)' title="Editar dados">
                            <i class="fa fa-edit text-primary"></i>
                        </a>
                    </big>
                HTML;
            }

            if(PermissionService::has('api/contasreceber/delete')){
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

                    <tr>
                        <td>
                            <label class="cursor-pointer" for="seletor-{$id}">
                                <input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar(`{$id}`)">
                                {$descricao}
                            </label>
                        </td>
                        <td>{$valor}</td>
                        <td>{$cliente}</td>
                        <td>{$vencimento}</td>
                        <td>{$data_pgto}</td>
                        <td>{$data_lanc}</td>
                        <td>{$forma_pagamento}</td>
                        <td style="font-size:12px">{$nome_frequencia}</td>
                        <td>{$observacao}</td>
                        <td>
                            <a target="_blank" href="{$link}">
                                <img
                                    style="
                                width:100px;
                                max-width:100%;
                                "
                                src="{$arquivo}"
                                />
                            </a>
                        </td>
                        <td style="font-size:14px">
                            <div class="rounded text-center w-100 {$classSituacao}" style="padding: 0px 4px 0px 4px;">
                                {$situacao}
                            </div>
                        </td>
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
                    url: "/api/contasreceber/delete/" + id,
                    method: 'GET',
                    success:function(result){
                        console.log(result);
                        try{
                            const response = JSON.parse(result);
                            if (!response.error) {            	
                                listarContasReceber(`{$data_ini_mes}`, `{$data_fim_mes}`);
                                notyf.success(response.message);
                            } else {
                                notyf.error(response.message);
                            }
                        }catch(err){
                            notyf.error(result);
                        }
                    },
                    error(xhr, status, error){
                        notyf.error(xhr.responseText)
                    }
                });
            }

            </script>
        HTML;
        
        return $res->send($html);
    }


    public function insert(Request $req, Response $res){

        $validatedArquivo = $req->post()->validate(ContasReceberArquivoRequest::class);
        
       

        if($validatedArquivo['error']){
            return $res->json([
                'error' => true,
                'message' => "Não foi possível fazer upload do arquivo.",
                'issues' => $validatedArquivo['issues'],
            ]);
        }
        
        $validated = $req->post()->validate(ContasReceberRequest::class);

        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => "Verifique os dados e tente novamente.",
                'issues' => $validated['issues'],
            ]);
        }

        $data = $validated['issues'];
        $upload = ['success' => false];
        if($validatedArquivo['error'] == false && $validatedArquivo['issues']['arquivo'] != null){
            $upload = (new ImageUploader($validatedArquivo['issues']['arquivo'], ['jpg', 'jpeg', 'png', 'gif', 'webp','xls',
                        'xlsx',
                        'doc',
                        'docx',
                        'pdf',
                        'rar',
                        'zip',
                        'xml'], 2048))->uploadImage();
                if($upload['success']){
                    $data['arquivo'] = $upload['filename'];
                }else{
                    return $res->json([
                    'error' => true,
                    'message' => "Não foi possível fazer upload do arquivo.",
                    'issues' => $validatedArquivo['issues'],
                ]);
            }
        }else{
            $data['arquivo'] = null;
        }

        try{
            $data['usuario_lanc'] = App::authSession()->get()->id;
            $response = $this->contasReceberService->insert($data);
            return $res->json($response->toArray());
        }catch(Throwable $e){
            if($upload['success']){
                unlink(UPLOAD_DIR . $upload['filename']);
            }
            return $res->json([
                'error' => true,
                'message' => 'Ocorreu um erro ao salvar os dados. Por favor, contate o administrador.',
                'issues' => [],
            ]);
        }
        
        return $res->json($response->toArray());
    }

    public function patch(Request $req, Response $res){

        $validatedArquivo = $req->post()->validate(ContasReceberArquivoRequest::class);
        
       

        if($validatedArquivo['error']){
            return $res->json([
                'error' => true,
                'message' => "Não foi possível fazer upload do arquivo.",
                'issues' => $validatedArquivo['issues'],
            ]);
        }
        
        $validated = $req->post()->validate(ContasReceberRequest::class, function($v){
            $v->custom([
            'id' => 'required|notNull|numberInt',
            'messages' => [
                "id.required" => "O campo id é obrigatório.",
                "id.notNull" => "O campo id não pode ser vazio.",
                "id.numberInt" => "O id deve ser um número interio."
            ]
            ]);
        });

        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => "Verifique os dados e tente novamente.",
                'issues' => $validated['issues'],
            ]);
        }

        $data = $validated['issues'];
        $upload = ['success' => false];
        if($validatedArquivo['error'] == false && $validatedArquivo['issues']['arquivo'] != null){
            $upload = (new ImageUploader($validatedArquivo['issues']['arquivo'], ['jpg', 'jpeg', 'png', 'gif', 'webp','xls',
                        'xlsx',
                        'doc',
                        'docx',
                        'pdf',
                        'rar',
                        'zip',
                        'xml'], 2048))->uploadImage();
                if($upload['success']){
                    $data['arquivo'] = $upload['filename'];
                }else{
                    return $res->json([
                    'error' => true,
                    'message' => "Não foi possível fazer upload do arquivo.",
                    'issues' => $validatedArquivo['issues'],
                ]);
            }
        }else{
            $data['arquivo'] = null;
        }

        try{
            $data['usuario_lanc'] = App::authSession()->get()->id;
            $response = $this->contasReceberService->patch($data);
            return $res->json($response->toArray());
        }catch(Throwable $e){
            if($upload['success']){
                unlink(UPLOAD_DIR . $upload['filename']);
            }
            return $res->json([
                'error' => true,
                'message' => 'Ocorreu um erro ao salvar os dados. Por favor, contate o administrador.',
                'issues' => [],
            ]);
        }

    }

    public function delete(int $id, Response $res){

        $response = $this->contasReceberService->trash($id);
   
        return $res->json($response->toArray());

    }





}
