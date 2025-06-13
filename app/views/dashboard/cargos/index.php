<?php

use app\facade\App;
use app\services\PermissionService;

?>


<?php if(PermissionService::has('api/cargos/insert')): ?>
<script>

	const inserirCargo = ()=>{
		$("#mensagem").text("");
		$("#titulo_inserir").text("Inserir registro");
		$("#modalFormCargos").modal("show");
		$("#formCargos").attr("action", "/api/cargos/insert");
}
</script>

<a onclick="inserirCargo()" class="btn btn-primary">
    <span class="fa fa-plus"></span>
    Cargos
</a>
<?php endif; ?>
<?php if(PermissionService::has('api/cargos')): ?>
<section class="bs-example widget-shadow p-15" id="listar">

</section>
 <?php else: ?>
	Você não tem permissão para listar os cargos.
<?php endif; ?>
<?php if(PermissionService::has('api/cargos/insert')): ?>
<!-- Modal Form -->
<div class="modal fade" id="modalFormCargos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= route('/api/cargos/insert') ?>" id="formCargos">
			<div class="modal-body">
				

					<div class="row gap-4">
						<div class="col-md-12">							
								<label>Nome do cargo*</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do acesso">							
						</div>
	    

						<input type="hidden" name="_csrf_token" value="<?= App::_csrf() ?>" />
						<input type="hidden" id="id" name="id" value="" />
						
					</div>


				<br>
				<small><div id="mensagem_acesso" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if(PermissionService::has('api/cargos/patch')): ?>

<script>
	const editarCargos = ($user)=>{
		$(document).ready(()=>{
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#modalFormCargos").modal("show");
			$("#formCargos").attr("action", "../api/cargos/patch");
			const parseUser = JSON.parse($user);
			$("#acesso_id").val($user.acesso_id)
			for(let i in parseUser){
				if($(`#${i}`).is("select")){
					$(`#${i}`).val(parseUser[i]).change();
				}else{
					$(`#${i}`).val(parseUser[i]);				
				}
			}
		})
	}
	$("#modalFormCargos").on("hidden.bs.modal", ()=>{
		limparCampos("#modalFormCargos")
	})
</script>
<?php endif; ?>
<?php if(PermissionService::has('api/cargos/patch') || PermissionService::has('api/cargos/insert')): ?>
<script>

	$("#formCargos").submit((e)=>{
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
					notyf.success(response.message);
					$(`#btn-fechar`).click();
					clearErrorMessages(); 
					listar();
					limparCampos("#modalFormCargos");
				}else{
					if(response.issues){
						const { issues } = response;
						setErrorMessages(issues);
					}
					notyf.error(response.message);

				}
			},
			error:(xhr, status, error)=>{
				$(`#mensagem_acesso`).text(xhr.responseText);
			}
		})
	})

</script>
<?php endif; ?>

<?php if(PermissionService::has('api/cargos')): ?>
<script>

	$(document).ready(()=>{
		listar()
	})

    const listar = ()=>{
		$.ajax({
			url: "<?php echo route("/api/cargos") ?>",
			method: "GET",
			dataType: "html",
			success: (result)=>{
           
				$("#listar").html(result);
				$("#mensagem-excluir").remove();
               
			}
		});
	}

</script>
<?php endif; ?>