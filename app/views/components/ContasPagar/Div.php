<!-- Modal Form -->
<div 	style="
		backdrop-filter: blur(2px);
	"
	class="modal fade" id="divContasReceber" tabindex="-1" aria-labelledby="contasReceberLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="contasReceberLabel">
					<span id="situacaoDados"></span>
					<button id="btn-fechar-conta" onclick="$('#divContasReceber').modal('close')" type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</h4>
			</div>
			<div id="">
			<div class="modal-body">

					<div class="row">
						<div class="col-md-6">							
							<label>Descrição</label>
							<span type="text" class="form-control" id="descricaoDados" >							
                            </span>
						</div>

						<div class="col-md-3">							
							<label>Valor</label>
							<span type="text" class="form-control" id="valorDados">							
                            </span>
						</div>

						<div class="col-md-3">							
							<label>Cliente</label>
							<span id="clienteDados" class="form-control" style="width: 100%;height:35px"></span>
						</div>
					</div>


					<div class="row">

						<div class="col-md-3">							
							<label>Data de vencimento</label>
						
							<span  class="form-control" id="vencimentoDados"  >							
                            </span>
						</div>

						<div class="col-md-3">							
							<label>Pago em</label>
							<span  class="form-control" id="data_pgtoDados">							
                            </span>
						</div>
						<div class="col-md-3">							
							<label>Forma de pagamento</label>
							<span id="forma_pagamentoDados" class="form-control">
							</span>						
						</div>

						<div class="col-md-3">							
							<label>Frequência</label>
							<span id="nome_frequenciaDados" class="form-control">
							</span>							
						</div>

					</div>

					<div class="row">
						<div class="col-md-4">
							<label>Multa</label>
							<span class="form-control" id="multaDados">							
                            </span>
						</div>
						<div class="col-md-4">
							<label>Juros</label>
							<span class="form-control" id="jurosDados">							
                            </span>
						</div>
						<div class="col-md-4">
							<label>Taxa</label>
							<span class="form-control" id="taxaDados">							
                            </span>
						</div>
						<div class="col-md-4">
							<label>Subtotal</label>
							<span class="form-control" id="subtotalDados">							
                            </span>
						</div>
					</div>

                    <div class="row">

						<div class="col-md-5">							
							<label>Observação</label>
							<span class="form-control" id="observacaoDados">							
                            </span>
						</div>
					</div>		
					<div class="row">
						<div class="col-md-2">		
							<a href="#" class="btn btn-link" id="arquivoDadosLink" target="_blank">
								<img src="" id="arquivoDados"  width="80px" alt="Arquivo">								
							</a>						
						</div>
					</div>
				<br>
				<small><div id="mensagem_conta" align="center"></div></small>
			</div>

            </div>
		</div>
	</div>
</div>
