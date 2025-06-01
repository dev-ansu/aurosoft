<?php

use app\facade\App;
use app\services\PermissionService;

$session = App::authSession()->get();


?>
</div>

	<!-- new added graphs chart js-->
	
	<script src="<?= asset("/js/Chart.bundle.js") ?>"></script>
	<script src="<?= asset("/js/utils.js") ?>"></script>
	
	
	
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="<?= asset("/js/classie.js") ?>"></script>
	<script>
		var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		showLeftPush = document.getElementById( 'showLeftPush' ),
		body = document.body;

		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'cbp-spmenu-push-toright' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
			disableOther( 'showLeftPush' );
		};


		function disableOther( button ) {
			if( button !== 'showLeftPush' ) {
				classie.toggle( showLeftPush, 'disabled' );
			}
		}
	</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->

	<!--scrolling js-->
	<script src="<?= asset("/js/jquery.nicescroll.js") ?>"></script>
	<script src="<?= asset("/js/scripts.js") ?>"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='<?= asset("/js/SidebarNav.min.js") ?>' type='text/javascript'></script>
	<script>
		$('.sidebar-menu').SidebarNav()
	</script>
	<!-- //side nav js -->
	
	
	
	<!-- Bootstrap Core JavaScript -->
	<script src="<?= asset("/js/bootstrap.js") ?>"> </script>
	<!-- //Bootstrap Core JavaScript -->



	
	<!-- Ajax para funcionar Mascaras JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 
	
	<!-- Mascaras JS -->
	<script type="text/javascript" src="<?= asset("/js/mascaras.js") ?>"></script>

	
</body>
</html>






<!-- Modal Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir">Inserir dados</span></h4>
				<button id="btn-fechar-perfil" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php 	
				if(PermissionService::has("perfil") && PermissionService::has("api/perfil")){
					component("/Perfil/FormPerfil", ['session' => @$session ]);
				}elseif(PermissionService::has("perfil") && !PermissionService::has("api/perfil")){
					component("/Perfil/DivPerfil", ['session' => @$session ]);
				}
			?>
		</div>
	</div>
</div>








<?php if(PermissionService::has('config')): ?>
<!-- Modal Config -->
<div class="modal fade" id="modalConfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Editar Configurações</h4>
				<button id="btn-fechar-config" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= route('/api/config') ?>" id="form-config">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-12">							
								<label>Nome do Projeto</label>
								<input type="text" class="form-control" id="nome_sistema" name="nome" placeholder="Nome do sistema" value="<?php echo @$config->nome ?>" required>							
					
						</div>
					</div>
					<div class="row">
						
						<div class="col-md-3">							
								<label>Email Sistema</label>
								<input type="email" class="form-control" id="email_sistema" name="email" placeholder="Email do Sistema" value="<?php echo @$config->email ?>" >							
						</div>


						<div class="col-md-3">							
								<label>Telefone Sistema</label>
								<input type="text" class="form-control" id="telefone_sistema" name="telefone" placeholder="Telefone do Sistema" value="<?php echo @$config->telefone ?>" required>							
						</div>

						<div class="col-md-3">							
								<label>WhatsApp</label>
								<input type="text" class="form-control" id="whatsapp_sistema" name="whatsapp" placeholder="WhatsApp" value="<?php echo @$config->whatsapp ?>" >							
						</div>

						<div class="col-md-3">							
								<label>Instagram</label>
								<input type="text" class="form-control" id="instagram_sistema" name="instagram" placeholder="Link do Instagram" value="<?php echo @$config->instagram ?>">							
						</div>
					</div>


					<div class="row">
						<div class="col-md-6">							
								<label>Rua</label>
								<input type="text" class="form-control" id="rua_sistema" name="rua" placeholder="Rua X..." value="<?php echo @$config->rua ?>" >							
						</div>
						<div class="col-md-6">							
								<label>Número</label>
								<input type="text" class="form-control" id="numero_sistema" name="numero" placeholder="Ex.: 10, 100" value="<?php echo @$config->numero ?>" >							
						</div>
						<div class="col-md-6">							
								<label>Bairro</label>
								<input type="text" class="form-control" id="bairro_sistema" name="bairro" placeholder="X..." value="<?php echo @$config->bairro ?>" >							
						</div>
					</div>			

			
				<br>
				<small><div id="mensagem_sistema" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>






<script type="text/javascript">
	function carregarImgPerfil() {
    var target = document.getElementById('target-usu');
    var file = document.querySelector("#foto_perfil").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>






<script type="text/javascript">
	function carregarImgLogo() {
    var target = document.getElementById('target-logo');
    var file = document.querySelector("#foto-logo").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>





<script type="text/javascript">
	function carregarImgLogoRel() {
    var target = document.getElementById('target-logo-rel');
    var file = document.querySelector("#foto-logo-rel").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>





<script type="text/javascript">
	function carregarImgIcone() {
    var target = document.getElementById('target-icone');
    var file = document.querySelector("#foto-icone").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>