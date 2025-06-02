<?php

use app\facade\App;
use app\services\PermissionService;

?>


<?php if(PermissionService::has("api/usuarios/insert")): ?>

	<a onclick="inserir()" class="btn btn-primary">
		<span class="fa fa-plus"></span>
		Receber
	</a>

<?php endif; ?>


<li id="" class="dropdown head-dpdn2" style="display: inline-block;">
	<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown toggle"
	id="btn-deletar" style="display: none;"
	><span class="fa fa-trash-o"></span>Deletar</a>

	<ul class="dropdown-menu">
		<li>
			<div class="notification_desc2">
				<p>Excluir selecionados? <a href="#" onclick="deletarSel()">
					<span class="text-danger">Sim</span>
				</a></p>
			</div>
		</li>
	</ul>
</li>

<section class="bs-example widget-shadow p-15" id="listar">

</section>
 
<div class="modal fade" id="permissoesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title d-flex justify-content-between align-items-center" id="permissoesModalLabel">
					<span id="nome_permissoes"></span>
					<span>
						<input class="form-check-input" type="checkbox" id="input_todos" onchange="marcarTodos()" />
						<label for="input_todos" id="titulo_inputs_marcar">Marcar todos</label>
					</span>				
				</h4>
				<button onclick="$('#permissoesModal').modal('close')" type="button" class="close"  data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="permissoesForm">
			<div class="modal-body">

				<div class="row" id="listar_permissoes">

				</div>

				<input type="hidden" id="permissoes_csrf_token" name="_csrf_token" value="<?= App::_csrf() ?>">
				<input type="hidden" id="id_permissoes" name="" value="">

				<br>
			</div>
			
			<small><div id="mensagem_permissao" align="center"></div></small>
		</form>
		</div>
	</div>
</div>



<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button onclick="$('#permissoesModal').modal('close')" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= route('/api/usuarios/insert') ?>" id="form">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-6">							
							<label>Descrição</label>
							<input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição">							
						</div>

						<div class="col-md-3">							
							<label>Valor</label>
							<input type="text" class="form-control" id="valor" name="valor" placeholder="100.00">							
						</div>

						<div class="col-md-3">							
							<label>Cliente</label>
							<select name="cliente" id="cliente" class="sel2 js-states form-control" style="width: 100%;height:35px">
								<option value="0">Nenhum</option>
								<option value="1">Cliente 1</option>
								<option value="2">Cliente 2</option>
							</select>
						</div>
					</div>


					<div class="row">

					
						

						<div class="col-md-3">							
							<label>Data de vencimento</label>
						
							<input  type="date" value="<?= date("Y-m-d") ?>" class="form-control" id="vencimento" name="vencimento" >							
						</div>

						<div class="col-md-3">							
							<label>Pago em</label>
							<input type="date" class="form-control" id="data_pgto" name="data_pgto" value="" placeholder="10/02/2023">							
						</div>
						<div class="col-md-3">							
							<label>Forma de pagamento</label>
							<select name="forma_pgto" id="forma_pgto" class="form-control">
								<option value="0">Dinheiro</option>
								<option value="1">Pix</option>
								<option value="2">Cartão de crédito</option>
							</select>						
						</div>

						<div class="col-md-3">							
							<label>Frequência</label>
							<select name="frequencia" id="frequencia" class="form-control">
								<option value="0">Nenhuma</option>
								<option value="1">Diária</option>
								<option value="2">Mensal</option>
								<option value="3">Anual</option>
							</select>							
						</div>

					</div>

                    <div class="row">

						<div class="col-md-5">							
							<label>Observação</label>
							<input type="text" class="form-control" id="observacao" name="observacao" placeholder="Observação">							
						</div>
					
						<div class="col-md-4">							
								<label>Arquivo</label>
								<input type="file" class="form-control" id="arquivo" name="arquivo" value="" onchange="carregarImg()">							
						</div>

						<div class="col-md-2">								
							<img src=""  width="80px" id="target" alt="Arquivo">								
						</div>

						
				
						<input type="hidden" name="_csrf_token" value="<?= App::_csrf() ?>" />
					</div>		
				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		$('.sel2').select2({
			dropdownParent: $("#modalForm")
		});
	});

	function carregarImg() {
		let target = document.getElementById('target');
		let file = document.getElementById("arquivo").files[0];
		
		const arquivo = file.name;
		const extensao = arquivo.split(".").pop().toLowerCase();
		

		if(['jpg', 'jpeg', 'png', 'webp', 'jiff'].includes(extensao)){
			target.src = `<?= asset("/icones/") ?>image.png`;
			return; // Não continue tentando carregar como imagem
		}else{
			
			target.src = `<?= asset("/icones/") ?>${extensao}.png`;
			return; // Não continue tentando carregar como imagem
		}
    
    }

</script>

<?php if(PermissionService::has("dashboard/usuarios")): ?>
<!-- Modal dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="nomeDados"></span></h4>
				<button onclick="$('#permissoesModal').modal('close')" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="dados">
			<div class="modal-body">

					<div class="col-md-6">							
							<label>Ativo</label>
							<span type="text" class="form-control" id="ativoDados"></span>								
					</div>

					<div class="row">

						<div class="col-md-6">							
								<label>Email</label>
								<span type="text" class="form-control" id="emailDados"></span>								
						</div>

						<div class="col-md-6">							
								<label>Telefone</label>
								<span type="text" class="form-control" id="telefoneDados"></span>							
						</div>
						
					</div>


					<div class="row">

						
						

						<div class="col-md-6">							
								<label>Nível</label>
								<span type="text" class="form-control" id="nivelDados"></span>							
						</div>


						
					</div>

                    <div class="row">
						<div class="col-md-4">							
								<label>Rua</label>
								<span type="text" class="form-control" id="ruaDados"></span>						
						</div>


						<div class="col-md-4">							
								<label>Número da casa</label>
								<span type="text" class="form-control" id="numeroDados"></span>						
						</div>

						<div class="col-md-4">							
								<label>Bairro</label>						
								<span type="text" class="form-control" id="bairroDados"></span>							
						</div>
						<div class="col-md-4">							
								<label>Cadastrado em</label>						
								<span type="text" class="form-control" id="created_atDados"></span>							
						</div>
			
					</div>		
				<br>
			</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- Modal permissões -->



<!-- Modal -->
<?php if(PermissionService::has('dashboard/usuarios')): ?>
<script>
	$(document).ready(()=>{
		listar();
	})

	const listar = ()=>{
		$.ajax({
			url: "<?php echo route("/api/usuarios") ?>",
			method: "GET",
			dataType: "html",
			success: (result)=>{
				$("#listar").html(result);
				$("#mensagem-excluir").hide();
			}
		});
	}

	const mostrar = ($user, action = '')=>{
		
		$(document).ready(()=>{
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#form").attr("action", "../api/usuarios/patch");
			const parseUser = JSON.parse($user);
			for(let i in parseUser){
				$(`#${i}Dados`).text(parseUser[i]);				
			}
		})
		$("#modalDados").modal("show");
	}
</script>
<?php endif; ?>


<?php if(PermissionService::has('api/usuarios/patch')): ?>
<script>

	const editar = ($user)=>{
		$(document).ready(()=>{
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#modalForm").modal("show");
			$("#form").attr("action", "../api/usuarios/patch");
			const parseUser = JSON.parse($user);
			for(let i in parseUser){
				if($(`#${i}`).is("select")){
					$(`#${i}`).val(parseUser[i]).change();
				}else{
					$(`#${i}`).val(parseUser[i]);				
				}
			}
		})
	}

</script>



<?php endif; ?>

<?php if(PermissionService::has('api/permissoes/insert')): ?>
<script>
	const marcarTodos = ()=>{
		const _csrf_token = document.getElementById("permissoes_csrf_token").value;
		
		$("#listar_permissoes input[type='checkbox']").each( (i, el)=>{
			if(el.checked == false){
				el.click();
			}
		})

	}


</script>
<?php endif; ?>


