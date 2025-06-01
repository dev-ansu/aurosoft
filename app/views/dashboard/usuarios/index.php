<?php

use app\facade\App;
use app\services\PermissionService;

?>


<?php if(PermissionService::has("api/usuarios/insert")): ?>

	<a onclick="inserir()" class="btn btn-primary">
		<span class="fa fa-plus"></span>
		Usuário
	</a>

<?php endif; ?>



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


<?php if(PermissionService::has("api/usuarios/insert")): ?>
<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
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
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome">							
						</div>

						<div class="col-md-6">							
								<label>Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Seu Email" >							
						</div>

						
					</div>


					<div class="row">

						<div class="col-md-6">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone">							
						</div>
						

						<div class="col-md-6">							
								<label>Nível</label>
								<select class="form-control" name="nivel" id="nivel">
								  <option>Administrador</option>
								  <option>Comum</option>
								</select>							
						</div>


						
					</div>

                    <div class="row">
						<div class="col-md-4">							
								<label>Rua</label>
								<input type="text" class="form-control" id="rua" name="rua" placeholder="Nome da rua" value="">							
						</div>


						<div class="col-md-4">							
								<label>Número da casa</label>
								<input type="text" class="form-control" id="numero" name="numero" placeholder="Número da casa" value="">							
						</div>

						<div class="col-md-4">							
								<label>Bairro</label>
								<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Nome do bairro" value="">							
								<input type="hidden" class="form-control" id="id" name="id" placeholder="" value="">							
						</div>
						<input type="hidden" name="_csrf_token" value="<?= App::_csrf() ?>" />
					</div>		
					
					<div class="row">

						<div class="col-md-6">							
							<label>Senha</label>
							<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" value="">												
						</div>
						
						<div class="col-md-6">							
							<label>Confirmar senha</label>
							<input type="password" class="form-control" id="senha_conf" name="senha_conf" placeholder="Confirmar senha" value="">							
						</div>

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
<?php endif; ?>

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
				$("#mensagem-excluir").remove();
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

<?php if(PermissionService::has('api/permissoes')): ?>
<script>

	const listarPermissoes = (id)=>{
		const _csrf_token = document.getElementById("permissoes_csrf_token").value;

		
		$.ajax({
			url: "<?= route("/api/permissoes") ?>",
			method: "POST",
			data: {id:id, _csrf_token: _csrf_token},
			dataType: "html",
			success: (result)=>{
		
				$("#listar_permissoes").html(result);
				$("#mensagem_permissao").text('');
		
				
			},
			error:(xhr, status, error)=>{
				console.log(xhr.responseText)
			}
		});
	}

	const definirPermissoes = (id, nome)=>{
		
		$(document).ready(()=>{
			$("#nome_permissoes").text(nome)
		
			$("#mensagem_permissao").text("");
			$("#id_permissoes").val(id)
			$("#permissoesModal").modal("show");

			listarPermissoes(id);

		})
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

	const adicionarPermissao = (permissao_id, usuario_id)=>{
		const _csrf_token = document.getElementById("permissoes_csrf_token").value;

		$.ajax({
			url: "<?= route("/api/permissoes/insert") ?>",
			method: "POST",
			data: {permissao_id, usuario_id, _csrf_token: _csrf_token},
			dataType: "html",
			success: (result)=>{
				const response = JSON.parse(result);
				if(response.error){
					const { issues } = response;
					$("#mensagem_permissao").text(response.message);
                    setErrorMessages(issues);
				}else{
					listarPermissoes(usuario_id);
					$("#mensagem_permissao").text(response.message);
				}
			},
			error:(xhr, status, error)=>{
				console.log(xhr.responseText)
			}
		});
	}
</script>
<?php endif; ?>
