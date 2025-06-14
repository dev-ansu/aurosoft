

<script>

	const inserirAcesso = ()=>{
		$("#mensagem").text("");
		$("#titulo_inserir").text("Inserir registro");
		$("#modalformAcesso").modal("show");
		$("#formAcesso").attr("action", "/api/acessos/insert");
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

						<div class="col-md-12" style="margin-top:12px">
							<label for="pagina">É uma página?</label>
							<select name="pagina" id="pagina" class="form-control">
								<option value="Não">Não</option>
								<option value="Sim">Sim</option>
							</select>
						</div>

						<input type="hidden" name="_csrf_token" value="<?= App::_csrf() ?>" />
						<input type="hidden" id="acesso_id" name="acesso_id" value="" />
						
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


<script>
	const editarAcessos = ($user)=>{
		$(document).ready(()=>{
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#modalformAcesso").modal("show");
			$("#formAcesso").attr("action", "../api/acessos/patch");
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
	$("#modalformAcesso").on("hidden.bs.modal", ()=>{
		limparCampos("#modalformAcesso")
	})
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
					$(`#mensagem_acesso`).text(response.message);
					$(`#btn-fechar`).click();
					clearErrorMessages(); 
					listar();
					limparCampos("#modalformAcesso");
				}else{
					if(response.issues){
						const { issues } = response;
						setErrorMessages(issues);
					}
					$(`#mensagem_acesso`).addClass("text-danger");
					$(`#mensagem_acesso`).text(response.message);
				}
			},
			error:(xhr, status, error)=>{
				$(`#mensagem_acesso`).text(xhr.responseText);
			}
		})
	})

	
</script>