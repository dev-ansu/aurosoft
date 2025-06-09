<!-- Modal Form -->
<div class="modal fade" id="modalFormaPagamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= route('/api/formaspagamento/insert') ?>" id="formFormaPagamento">
			<div class="modal-body">
				

					<div class="row gap-4">
						<div class="col-md-6">							
								<label>Nome*</label>
								<input type="text" class="form-control" id="nome_forma_pagamento" name="nome_forma_pagamento" placeholder="Nome da forma de pagamento, ex.: dinheiro">							
						</div>

						<div class="col-md-6">							
								<label>Taxa em R$</label>
								<input type="text" class="form-control" id="taxa" name="taxa" placeholder="Taxa">							
						</div>


						<?php

                            use app\facade\App;
                            use app\services\PermissionService;

                        if(PermissionService::has("api/formaspagamento/patch")): ?>
							<input type="hidden" id="id_forma_pagamento" name="id_forma_pagamento" value="" />
						<?php endif; ?>
						
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