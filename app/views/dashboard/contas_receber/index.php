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

<section style="overflow: auto;" class="bs-example widget-shadow p-15" id="listar">

</section>
 

<?php component("/ContasReceber/Form", [
	'frequencias' => $frequencias,
	'formasPgto' => $formasPgto,
]) ?>


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
<?php component("/ContasReceber/Div") ?>
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
			console.log(parseUser);
			for(let i in parseUser){
				if(i === "arquivo"){
					const arquivo = parseUser[i];
					if(arquivo){

						const extensao = arquivo.split(".").pop().toLowerCase();
						if(['jpg', 'jpeg', 'png', 'webp', 'jiff'].includes(extensao)){
							let file = `<?= BASE_URL ?>/uploads/${parseUser[i]}`;
							$(`#${i}Dados`).attr("src", file);	
						}else{
							let file = `<?= asset("/icones/") ?>${extensao}.png`;
							$(`#${i}Dados`).attr("src", file);	
						}
					}
									
				}else{
					$(`#${i}Dados`).text(parseUser[i] ?? '');				
				}
			}
		})
		$("#divContasReceber").modal("show");
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
		limparCampos("#formContasReceber");

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
					notyf.success(response.message)
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
	
	$("#modalFormContasReceber").on("hidden.bs.modal", ()=>{
		clearErrorMessages();
	})
</script>


