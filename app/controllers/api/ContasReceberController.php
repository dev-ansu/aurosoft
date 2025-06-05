<?php

namespace app\controllers\api;

use app\classes\FileUploader;
use app\classes\ImageUploader;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\facade\App;
use app\requests\ContasReceber\ContasReceberArquivoRequest;
use app\requests\ContasReceber\ContasReceberRequest;
use app\services\ContasReceber\ContasReceberService;
use app\services\PermissionService;
use DateTime;
use Exception;
use Throwable;

class ContasReceberController{


    public function __construct(private ContasReceberService $contasReceberService)
    {
        
    }

    public function index(Request $req, Response $res){
        $contas_receber = $this->contasReceberService->fetchAll()->data;

  
        $html = <<<HTML
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

        foreach($contas_receber as $conta_receber){
            // $conta_receber->created_at = (new DateTime($conta_receber->created_at))->format('d/m/Y');
            $editUser = json_encode($conta_receber);
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

            $situacao = "Em aberto";

            if(!is_null($data_pgto) || !$data_pgto == null){
                $situacao = "Confirmado";
            }elseif((new DateTime())->format('Y-m-d') > date("Y-m-d", strtotime($vencimento)) && (is_null($data_pgto) || $data_pgto == null)){
                $situacao = "Vencido";
            }

            $vencimento = (new DateTime($vencimento))->format('d/m/Y');
           
     
            $link = UPLOADS_PATH . "/".$arquivo;
            
            if($arquivo){
                $exploded = explode(".", $arquivo);
                $extensao = array_pop($exploded);

                if(in_array($extensao, ['jpg', 'jpeg', 'png', 'webp', 'jiff'])){
                    $arquivo = asset("/icones/image.png");
                }else{
                    $arquivo = asset("/icones/{$extensao}.png");
                }
                
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

                    <tr">
                        <td>{$descricao}</td>
                        <td>{$valor}</td>
                        <td>{$cliente}</td>
                        <td>{$vencimento}</td>
                        <td>{$data_pgto}</td>
                        <td>{$data_lanc}</td>
                        <td>{$nome}</td>
                        <td style="font-size:12px">{$nome_frequencia}</td>
                        <td>{$observacao}</td>
                        <td>
                            <a target="_blank" href="{$link}">
                                <img
                                    style="
                                max-width:100%;
                                "
                                src="{$arquivo}"
                                />
                            </a>
                        </td>
                        <td style="font-size:12px">
                            {$situacao}
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

    }

    public function delete(int $id, Response $res){

    }





}
