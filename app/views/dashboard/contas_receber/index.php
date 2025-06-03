<?php

use app\facade\App;
use app\services\PermissionService;

?>


<?php if(PermissionService::has("api/contasreceber/insert")): ?>
	
	<a onclick="inserirContaReceber()" class="btn btn-primary">
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
 


<!-- Modal Form -->
<div class="modal fade" id="modalFormContasReceber" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar-conta" onclick="$('#permissoesModal').modal('close')" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="<?php echo route("/api/contasreceber/insert") ?>" id="formContasReceber">
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
								<option value="">Nenhum</option>
								<?php foreach($formasPgto as $formaPgto): ?>
									<option value="<?= $formaPgto->id ?>"><?= $formaPgto->nome ?></option>
								<?php endforeach; ?>
							</select>						
						</div>

						<div class="col-md-3">							
							<label>Frequência</label>
							<select name="frequencia" id="frequencia" class="form-control">
								<option value="">Nenhum</option>
								<?php foreach($frequencias as $frequencia): ?>
									<option value="<?= $frequencia->id ?>"><?= $frequencia->frequencia ." ($frequencia->dias dia(s))" ?></option>
								<?php endforeach; ?>
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
				<small><div id="mensagem_conta" align="center"></div></small>
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
			dropdownParent: $("#modalFormContasReceber")
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

<?php if(PermissionService::has("dashboard/contasreceber")): ?>
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
<?php if(PermissionService::has('dashboard/contasreceber')): ?>
<script>
	$(document).ready(()=>{
		listar();
	})

	const listar = ()=>{
		$.ajax({
			url: "<?php echo route("/api/contasreceber") ?>",
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
			$("#formContasReceber").attr("action", "../api/contasreceber/patch");
			const parseUser = JSON.parse($user);
			for(let i in parseUser){
				$(`#${i}Dados`).text(parseUser[i]);				
			}
		})
		$("#modalDados").modal("show");
	}
</script>
<?php endif; ?>


<?php if(PermissionService::has('api/contasreceber/patch')): ?>
<script>

	const editarContaReceber = ($user)=>{
		$(document).ready(()=>{
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#modalFormContasReceber").modal("show");
			$("#formContasReceber").attr("action", "../api/contasreceber/patch");
			const parseUser = JSON.parse($user);
			for(let i in parseUser){
				if(i == "arquivo"){
					if(parseUser[i]){

						const arquivo = parseUser[i];
						const extensao = arquivo.split(".").pop().toLowerCase();
						if(['jpg', 'jpeg', 'png', 'webp', 'jiff'].includes(extensao)){
							target.src = `<?= asset("/icones/") ?>image.png`;
							return; // Não continue tentando carregar como imagem
						}else{
							target.src = `<?= asset("/icones/") ?>${extensao}.png`;
							return; // Não continue tentando carregar como imagem
						}
						$("#arquivo").val($arquivo);
					}
				}
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

<script>

	const inserirContaReceber = ()=>{
		$("#mensagem_conta").text("");
		$("#titulo_inserir").text("Nova forma de pagamento");
		$("#modalFormContasReceber").modal("show");
		$("#formContasReceber").attr("action", "/api/contasreceber/insert");
}

$("#formContasReceber").submit((e)=>{
		e.preventDefault();
		const button = 	e.target.querySelector("button")
		const formData = new FormData(e.target);

		button.textContent = "Carregando...";
		button.disabled = true;

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
						$(`#mensagem_conta`).text(response.message);
						$(`#btn-fechar-conta`).click();
						clearErrorMessages(); 
						listar();
						limparCampos("#formContasReceber");
					}else{
						if(response.issues){
							const { issues } = response;
							setErrorMessages(issues);
						}
						$(`#mensagem_conta`).addClass("text-danger");
						$(`#mensagem_conta`).text(response.message);
					}
					button.disabled = false;
					button.textContent = "SALVAR";
				}catch(err){
					button.disabled = false;
					button.textContent = "SALVAR";
					$(`#mensagem_conta`).text(data);
				}
			},
			error:(xhr, status, error)=>{
				$(`#mensagem_conta`).text(xhr.responseText);
				button.disabled = false;
				button.textContent = "SALVAR";
			}
		})
	})

</script>


