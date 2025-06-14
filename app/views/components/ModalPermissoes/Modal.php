<?php

use app\facade\App;
use app\services\PermissionService;

?>
<div class="modal fade" id="permissoesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
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
			<div class="modal-footer">
				<h4 class="modal-title d-flex justify-content-between align-items-center" id="permissoesModalLabel">
					<span>
						<span class="btn btn-lg btn-danger" type="checkbox" id="input_todos" onclick="desmarcarTodos()">Desmarcar todos</span>
					</span>				
				</h4>
			</div>
		</form>
		</div>
	</div>
</div>


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
	const desmarcarTodos = ()=>{
		const _csrf_token = document.getElementById("permissoes_csrf_token").value;
		
		$("#listar_permissoes input[type='checkbox']").each( (i, el)=>{
			if(el.checked == true){
				el.click();
			}
		})

	}

	const adicionarPermissao = (permissao_id, cargo_id)=>{
		const _csrf_token = document.getElementById("permissoes_csrf_token").value;

		$.ajax({
			url: "<?= route("/api/permissoes/insert") ?>",
			method: "POST",
			data: {permissao_id, cargo_id, _csrf_token: _csrf_token},
			dataType: "html",
			success: (result)=>{
				const response = JSON.parse(result);
				if(response.error){
					const { issues } = response;
					$("#mensagem_permissao").text(response.message);
                    setErrorMessages(issues);
				}else{
					listarPermissoes(cargo_id);
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