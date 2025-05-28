

<script>

	const inserirAcesso = ()=>{
		$("#mensagem").text("");
		$("#titulo_inserir").text("Inserir registro");
		$("#modalformAcesso").modal("show");
}
</script>

<a onclick="inserirAcesso()" class="btn btn-primary">
    <span class="fa fa-plus"></span>
    Acesso
</a>


<section class="bs-example widget-shadow p-15" id="listar">

</section>
 

<!-- Modal Form -->
<div class="modal fade" id="modalformAcesso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= route('/api/acessos/insert') ?>" id="formAcesso">
			<div class="modal-body">
				

					<div class="row gap-4">
						<div class="col-md-12">							
								<label>Nome do menu*</label>
								<input type="text" class="form-control" id="nome_acesso" name="nome_acesso" placeholder="Nome do acesso">							
						</div>

						<div class="col-md-12">							
								<label>Chave*</label>
								<input type="text" class="form-control" id="chave" name="chave" placeholder="Chave">							
						</div>

                        <div class="col-md-12">							
                            <label>Grupo</label>
							<?php

                            use app\facade\App;

 							if(count($grupos) >= 0): ?>
                            <select class="form-control" name="grupo_id" id="grupo_id">
								<option value="">Sem grupo</option>
                                <?php foreach(@$grupos as $grupo): ?>
                                    <option value="<?= $grupo->id ?>"><?= $grupo->nome ?></option>
                                <?php endforeach; ?>
                            </select>
							<?php else: ?>
								<?= 'Cadastre um grupo de acesso' ?>
							<?php endif; ?>

						</div>
						<input type="hidden" name="_csrf_token" value="<?= App::_csrf() ?>" />
						<input type="hidden" id="acesso_id" name="acesso_id" value="" />
						
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


<script>
	const editarAcessos = ($user)=>{
		$(document).ready(()=>{
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#modalformAcesso").modal("show");
			$("#formAcesso").attr("action", "../api/acessos/patch");
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

<script>

	$(document).ready(()=>{
		listar()
	})

    const listar = ()=>{
		$.ajax({
			url: "<?php echo route("/api/acessos") ?>",
			method: "GET",
			dataType: "html",
			success: (result)=>{
           
				$("#listar").html(result);
				$("#mensagem-excluir").remove();
               
			}
		});
	}

	$("#formAcesso").submit((e)=>{
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
					// limparCampos($("#modalForm"));
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