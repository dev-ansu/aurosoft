<?php

use app\facade\App;
use app\services\PermissionService;

$csrf = App::_csrf();
?>
<script>
	let data_ini = '';
	let data_fim = '';
	let situacao = '';

</script>


<div class="d-flex gap-2">
<?php if(PermissionService::has("api/contasreceber/insert")): ?>

		<div class="">
			<a onclick="inserirContaReceber()" class="btn btn-primary">
				<span class="fa fa-plus"></span>
				Receber
			</a>
		</div>

<?php endif; ?>


		<div class="">
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
		</div>		
</div>	

		
<div class="row d-flex flex-column gap-2 justify-content-start align-items-start">
		<?php 
			$today = new DateTime();

			$data_ini_mes = (new DateTime('first day of this month'))->format('Y-m-d');
			$data_fim_mes = (new DateTime('last day of this month'))->format('Y-m-d');
			
			$data_ini_mes_passado = (new DateTime('first day of last month'))->format('Y-m-d');
			$data_fim_mes_passado = (new DateTime('last day of last month'))->format('Y-m-d');

			$data_ini_mes_proximo = (new DateTime('first day of next month'))->format('Y-m-d');
			$data_fim_mes_proximo = (new DateTime('last day of next month'))->format('Y-m-d');

			$inicioSemana = clone $today;
			$inicioSemana = $inicioSemana->modify('monday this week')->format('Y-m-d');

			$fimSemana = clone $today;
			$fimSemana = $fimSemana->modify('sunday this week')->format('Y-m-d');
			
			
		?>
		<div class="d-flex gap-2">
			<div class="d-flex flex-column gap-2">
				<p>Vencimento</p>
				<div class="d-flex gap-2">
					<div class="d-flex gap-1 align-items-center">
						<label for="">De</label>
						<input id="data_ini" value="<?= $data_ini_mes ?>" type="date" class="form-control">
					</div>
					<div class="d-flex gap-1 align-items-center">
						<label for="">a</label>
						<input id="data_fim" value="<?= $data_fim_mes ?>" type="date" class="form-control">
					</div>
				</div>
			</div>
			<div class="d-flex flex-column gap-2">
				<p>Situação</p>
				<div class="d-flex gap-2">
					<select name="filtrar_situacao" class="form-control" id="filtrar_situacao">
						<option value="">Todas</option>
						<option value="ab">Em aberto</option>
						<option value="at">Em atraso</option>
						<option value="pg">Confirmado</option>
					</select>
				</div>
			</div>
		</div>
		<div class="d-flex gap-1">
			<button data-date-ini="<?= $today->format('Y-m-d') ?>" data-date-fim="<?= $today->format('Y-m-d') ?>" class="btn btn-link btn-filtrar">Hoje</button>
			<button data-date-ini="<?= $inicioSemana ?>" data-date-fim="<?= $fimSemana ?>" class="btn btn-link btn-filtrar">Esta semana</button>
			<button data-date-ini="<?= $data_ini_mes ?>" data-date-fim="<?= $data_fim_mes ?>" class="btn btn-link btn-filtrar">Este mês</button>
			<button data-date-ini="<?= $data_ini_mes_passado ?>" data-date-fim="<?= $data_fim_mes_passado ?>" class="btn btn-link btn-filtrar">Mês passado</button>
			<button data-date-ini="<?= $data_ini_mes_proximo ?>" data-date-fim="<?= $data_fim_mes_proximo ?>" class="btn btn-link btn-filtrar">Pŕoixmo mês</button>
			<button data-date-ini="" data-date-fim="" class="btn btn-link btn-filtrar">Todo o período</button>
			<button data-date-ini="<?= $data_ini_mes ?>" data-date-fim="<?= $data_fim_mes ?>" class="btn btn-link btn-limpar">Limpar</button>
		</div>
</div>



<section style="overflow: auto;" class="" id="listar">

</section>
 

<?php component("/ContasReceber/Form", [
	'frequencias' => $frequencias,
	'formasPgto' => $formasPgto,
	'csrf' => $csrf,
]) ?>
<?php component("/ContasReceber/Baixar", [
	'formasPgto' => $formasPgto,
	'today' => $today,
	'csrf' => $csrf,
]) ?>
<?php component("/ContasReceber/Parcelar", [
	'formasPgto' => $formasPgto,
	'frequencias' => $frequencias,
	'today' => $today,
	'csrf' => $csrf,
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
		listarContasReceber(`<?= $data_ini_mes ?>`,`<?= $data_fim_mes ?>`);
	})

	const listarContasReceber = (data_ini='', data_fim ='', situacao = '')=>{
		$.ajax({
			url: `<?php echo route("/api/contasreceber") ?>?data_ini=${data_ini}&data_fim=${data_fim}&situacao=${situacao}`,
			method: "GET",
			dataType: "html",
			success: (result)=>{
				$("#listar").html(result);
				$("#mensagem-excluir").hide();
			}
		});
	}

	$(document).on("click", ".btn-filtrar", (e)=>{
		e.preventDefault();
		const {dateIni, dateFim} = e.target.dataset;
		data_ini = dateIni;
		data_fim = dateFim;
		situacao = $("#filtrar_situacao").val();
		$("#data_ini").val(data_ini)
		$("#data_fim").val(data_fim)
		listarContasReceber(data_ini, data_fim, situacao)
	})
	$(document).on("click", ".btn-limpar", (e)=>{
		e.preventDefault();
		const {dateIni, dateFim} = e.target.dataset;
		data_ini = dateIni;
		data_fim = dateFim;
		situacao = ''
		$("#filtrar_situacao").val('');
		$("#data_ini").val(data_ini)
		$("#data_fim").val(data_fim)
		listarContasReceber(data_ini, data_fim, situacao)
	})

	$(document).on("change", "#data_fim, #data_ini, #filtrar_situacao", (e)=>{

		data_ini = $("#data_ini").val();
		data_fim = $("#data_fim").val();
		situacao = $("#filtrar_situacao").val();
	

		e.preventDefault();

		
		listarContasReceber(data_ini, data_fim, situacao)
		

	});

	const baixar = (conta)=>{
		const json = JSON.parse(conta);

		for(let i in json){
			if(i !== 'data_pgto'){
				$(`#${i}_baixar`).val(json[i]);				
			}
		}
		
		$("#baixarParcelaModal").modal("show");
	}
	const parcelar = (conta)=>{
		const json = JSON.parse(conta);

		for(let i in json){
			if(i !== 'data_pgto'){
				$(`#${i}_parcelar`).val(json[i]);				
			}
		}
		
		$("#parcelarModal").modal("show");
	}


	const mostrar = ($user, action = '')=>{
		
		$(document).ready(()=>{
			$("#mensagem").text("");
			$("#titulo_inserir").text("Atualizar registro");
			$("#formContasReceber").attr("action", "../api/contasreceber/patch");
			const parseUser = JSON.parse($user);
	
			for(let i in parseUser){
				if(i === "arquivo"){
					const arquivo = parseUser[i];
					if(arquivo){

						const extensao = arquivo.split(".").pop().toLowerCase();
						if(['jpg', 'jpeg', 'png', 'webp', 'jiff'].includes(extensao)){
							let file = `<?= BASE_URL ?>/uploads/${parseUser[i]}`;
							$(`#${i}Dados`).attr("src", file);	
							$(`#${i}DadosLink`).attr("href", file);
						}else{
							let file = `<?= asset("/icones/") ?>${extensao}.png`;
							let file2 = `<?= BASE_URL ?>/uploads/${parseUser[i]}`;
							$(`#${i}Dados`).attr("src", file);	
							$(`#${i}DadosLink`).attr("href", file2);
						}
					}
									
				}else{
					if(i == 'vencimento' || i == 'data_pgto'){
						const date = parseUser[i] ? parseUser[i].split("-").reverse().join("/"):'';
						$(`#${i}Dados`).text(date);				
					}else{
						$(`#${i}Dados`).text(parseUser[i] ?? '');				
					}
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
				
					if(response.error == false){
						$(`#mensagem_conta`).text(response.message);
						$(`#btn-fechar-conta`).click();
						clearErrorMessages(); 
							notyf.success(response.message)
						listarContasReceber(data_ini, data_fim, situacao);
						limparCampos("#formContasReceber");
					}else{
						if(response.issues){
							const { issues } = response;
							setErrorMessages(issues);
						}
							notyf.error(response.message)
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


