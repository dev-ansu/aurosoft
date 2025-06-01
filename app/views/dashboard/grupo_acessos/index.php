
<?php

use app\services\PermissionService;
?>

<?php if(PermissionService::has("api/grupoacessos/insert")): ?>
<script>

	const inserirGrupo = ()=>{
		$("#mensagem").text("");
		$("#titulo_inserir").text("Inserir registro");
		$("#modalFormGrupo").modal("show");
		$("#formGrupo").attr("action", "../api/grupoacessos/insert");
}
</script>


<a onclick="inserirGrupo()" class="btn btn-primary">
    <span class="fa fa-plus"></span>
    Grupo
</a>
<?php endif; ?>


<section class="bs-example widget-shadow p-15" id="listar">

</section>
 
<?php if(PermissionService::has("api/grupoacessos/insert") || PermissionService::has("api/grupoacessos/patch")): ?>
<!-- Modal Form -->
<div class="modal fade" id="modalFormGrupo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= route('/api/grupoacessos/insert') ?>" id="formGrupo">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-12">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome_grupo" name="nome_grupo" placeholder="Nome do grupo">							
								<input type="hidden" class="form-control" id="grupo_id" name="grupo_id" placeholder="Nome do grupo">							
						</div>
						<input type="hidden" name="_csrf_token" value="<?= $token_csrf ?>" />
						
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

<?php if(PermissionService::has("api/grupoacessos/insert") || PermissionService::has("api/grupoacessos/patch")): ?>
<script>

	
	const editarGrupo = ($user)=>{
		$(document).ready(()=>{
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#modalFormGrupo").modal("show");
			$("#formGrupo").attr("action", "../api/grupoacessos/patch");
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

	$("#formGrupo").submit((e)=>{
		e.preventDefault();
		
		const formData = new FormData(e.target);

		$.ajax({
			url: e.target.action,
			type: "POST",
			processData: false,
			data: formData,
			contentType: false,
			cache: false,

			success: (data)=>{
				const response = JSON.parse(data);
	
				if(response.error == false){
					$(`#mensagem`).text(response.message);
					$(`#btn-fechar`).click();
					clearErrorMessages(); 
					listar();
					limparCampos("#formGrupo");
				}else{
					if(response.issues){
						const { issues } = response;
						setErrorMessages(issues);
					}
					$(`#mensagem`).addClass("text-danger");
					$(`#mensagem`).text(response.message);
				}
			},
			error:(xhr, status, error)=>{
				$(`#mensagem`).text(xhr.responseText);
			}
		})
	})

	
</script>
<?php endif; ?>


<script>

	$(document).ready(()=>{
		listar()
	})

    const listar = ()=>{
		$.ajax({
			url: "<?php echo route("/api/grupoacessos") ?>",
			method: "GET",
			dataType: "html",
			success: (result)=>{
				$("#listar").html(result);
				$("#mensagem-excluir").attr("style", "display:none")
			}
		});
	}
	

</script>