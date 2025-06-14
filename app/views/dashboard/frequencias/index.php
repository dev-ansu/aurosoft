<?php

use app\facade\App;
use app\services\PermissionService;

?>

<?php if(PermissionService::has("api/frequencias/insert")): ?>
<script>

	const inserirFrequencia = ()=>{
		$("#mensagem").text("");
		$("#titulo_inserir").text("Nova frequência");
		$("#modalFrequencia").modal("show");
		$("#formFrequencia").attr("action", "/api/frequencias/insert");
		clearErrorMessages(); 
	}

	$("#formFrequencia").submit((e)=>{
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
				try{

					const response = JSON.parse(data);
		
					if(response.error == false){
						$(`#mensagem_acesso`).text(response.message);
						$(`#btn-fechar`).click();
						clearErrorMessages(); 
						listar();
						limparCampos("#modalFrequencia");
					}else{
						if(response.issues){
							const { issues } = response;
							setErrorMessages(issues);
						}
						$(`#mensagem_acesso`).addClass("text-danger");
						$(`#mensagem_acesso`).text(response.message);
					}
				}catch(err){
					$(`#mensagem_acesso`).text(data);
				}
			},
			error:(xhr, status, error)=>{
				$(`#mensagem_acesso`).text(xhr.responseText);
			}
		})
	})
</script>

<a onclick="inserirFrequencia()" class="btn btn-primary">
    <span class="fa fa-plus"></span>
    Nova frequência
</a>
<?php endif; ?>


<section class="bs-example widget-shadow p-15" id="listar">

</section>
 
<?php if(PermissionService::has("api/frequencias/insert") || PermissionService::has("api/frequencias/patch")): ?>
<!-- Modal Form -->
<div class="modal fade" id="modalFrequencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= route('/api/frequencias/insert') ?>" id="formFrequencia">
			<div class="modal-body">
				

					<div class="row gap-4">
						<div class="col-md-6">							
								<label>Nome da frequência*</label>
								<input type="text" class="form-control" id="nome_frequencia" name="nome_frequencia" placeholder="Nome da frequência, ex.: anual">							
						</div>

						<div class="col-md-6">							
								<label>Qtd. dias*</label>
								<input type="text" class="form-control" id="dias" name="dias" placeholder="Qtd. dias, ex.: 360">							
						</div>

	
						<input type="hidden" id="id_frequencia" name="id_frequencia" value="" />
						<input type="hidden" name="_csrf_token" value="<?= App::_csrf() ?>" />
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

<?php if(PermissionService::has("api/frequencias/patch")): ?>
<script>
	const editarFrequencia = ($user)=>{
		$(document).ready(()=>{
			clearErrorMessages(); 
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#modalFrequencia").modal("show");
			$("#formFrequencia").attr("action", "../api/frequencias/patch");
			const parseUser = JSON.parse($user);
			$("#id").val($user.id)
			for(let i in parseUser){
				if($(`#${i}`).is("select")){
					$(`#${i}`).val(parseUser[i]).change();
				}else{
					$(`#${i}`).val(parseUser[i]);				
				}
			}
		})
	}
	$("#modalFrequencia").on("hidden.bs.modal", ()=>{
		limparCampos("#modalFrequencia")
		$(`#mensagem_acesso`).text('');
		clearErrorMessages(); 
	})
</script>
<?php endif; ?>

<?php if(PermissionService::has("api/frequencias")): ?>
<script>

	$(document).ready(()=>{
		listar()
	})

    const listar = ()=>{
		$.ajax({
			url: "<?php echo route("/api/frequencias") ?>",
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