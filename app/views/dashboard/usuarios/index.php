<?php

use app\facade\App;
?>



<a onclick="inserir()" class="btn btn-primary">
    <span class="fa fa-plus"></span>
    Usuário
</a>



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
						<label for="input_todos">Marcar todos</label>
					</span>				
				</h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= route('/api/usuarios/insert') ?>" id="permissoesForm">
			<div class="modal-body">

				<div class="row" id="listar_permissoes">

				</div>

	
				<input type="hidden" id="id_permissoes" name="id_permissoes">
				<input type="hidden" id="permissoes_csrf_token" name="_csrf_token" value="<?= App::_csrf() ?>">

				<br>
				<small><div id="mensagem_permissao" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
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
						<input type="hidden" name="_csrf_token" value="<?= @$token ?>" />
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
<!-- Modal dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="nomeDados"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
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


<!-- Modal permissões -->



<!-- Modal -->


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
	
	const listarPermissoes = (id)=>{
		const _csrf_token = document.getElementById("permissoes_csrf_token").value;

		$.ajax({
			url: "<?php echo route("/api/permissoes") ?>",
			method: "POST",
			data: {id, _csrf_token: _csrf_token},
			dataType: "html",
			success: (result)=>{
				$("#listar_permissoes").html(result);
				$("#mensagem_permissao").text(result);
			}
		});
	}

	const definirPermissoes = (id, nome)=>{
		
		$(document).ready(()=>{
			$("#nome_permissoes").text(nome)
			$("#mensagem_permissoes").text("");
			$("#id_permissoes").val(id)
			$("#permissoesModal").modal("show");

			listarPermissoes(id);

		})
	}

</script>