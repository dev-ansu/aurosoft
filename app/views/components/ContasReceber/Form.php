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
			<form method="POST" action="<?php

use app\facade\App;

 echo route("/api/contasreceber/insert") ?>" id="formContasReceber">
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
						<input type="hidden" name="id" value="" id="id" />
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
