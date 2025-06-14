<?php

use app\facade\App;
use app\services\PermissionService;

?>

<?php if(PermissionService::has('/api/formaspagamento/patch') || PermissionService::has('/api/formaspagamento/insert')): ?>
<?php component('/FormasPagamento/Form'); ?>
<?php endif; ?>

<?php if(PermissionService::has("api/api/formaspagamento/insert")): ?>
<script>

	const inserirFormaPagamento = ()=>{
		$("#mensagem").text("");
		$("#titulo_inserir").text("Nova forma de pagamento");
		$("#modalFormaPagamento").modal("show");
		$("#formFormaPagamento").attr("action", "/api/formaspagamento/insert");
}

$("#formFormaPagamento").submit((e)=>{
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
						limparCampos("#modalFormaPagamento");
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

<a onclick="inserirFormaPagamento()" class="btn btn-primary">
    <span class="fa fa-plus"></span>
    Forma de pagamento
</a>

<?php endif; ?>


<section class="bs-example widget-shadow p-15" id="listar">

</section>
 



<?php if(PermissionService::has('/api/formaspagamento/patch')): ?>
	<script>
		const editarFormaPagamento = ($user)=>{
			$(document).ready(()=>{
				$("#mensagem").text("");
				$("#titulo_inserir").text("Atualizar registro");
				$("#modalFormaPagamento").modal("show");
				$("#formFormaPagamento").attr("action", "../api/formaspagamento/patch");
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
		$("#modalFormaPagamento").on("hidden.bs.modal", ()=>{
			limparCampos("#modalFormaPagamento")
			$(`#mensagem_acesso`).text('');
		})
	</script>
<?php endif; ?>

<?php if(PermissionService::has('api/formaspagamento')): ?>

<script>

	$(document).ready(()=>{
		listar()
	})

    const listar = ()=>{
		$.ajax({
			url: "<?php echo route("/api/formaspagamento") ?>",
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