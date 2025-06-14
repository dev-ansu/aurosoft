<!-- Modal -->
<div class="modal fade" id="baixarParcelaModal" tabindex="-1" role="dialog" aria-labelledby="baixarParcelaModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="baixarParcelaModalTitle">Baixar conta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="baixarParcelaForm" action="<?= route('/api/contasreceber/baixar') ?>">
            
            <input type="hidden" id="id_baixar" name="id">

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="valor_baixar">Valor</label>
                    <input type="text" id="valor_baixar" onkeyup="totalizar()" name="valor" class="form-control">                
                </div>
                <div class="form-group col-md-6">
                    <label for="valor_baixar">Forma de pagamento</label>
                
                    <select name="forma_pgto" id="forma_pgto_baixar" class="form-control">
                        <option value=""></option>
                        <?php
                        foreach($formasPgto as $formaPgto): ?>
                            <option value="<?= $formaPgto->id ?>"><?= $formaPgto->nome ?> (tx. R$: <?php echo number_format($formaPgto->taxa,2,',','.') ?>)</option>
                        <?php endforeach; ?>
                    </select>	
                </div>
            </div>

            <div class="row">

                <div class="form-group col-md-3">
                    <label for="multa_baixar">Multa em R$</label>
                    <input type="text" class="form-control" onkeyup="totalizar()" name="multa" id="multa_baixar">
                </div>
                <div class="form-group col-md-3">
                    <label for="juros_baixar">Juros em R$</label>
                    <input type="text" class="form-control" onkeyup="totalizar()" name="juros" id="juros_baixar">
                </div>
                <div class="form-group col-md-3">
                    <label for="desconto_baixar">Desconto em R$</label>
                    <input type="text" onkeyup="totalizar()" class="form-control" name="desconto" id="desconto_baixar">
                </div>
                <div class="form-group col-md-3">
                    <label for="desconto_baixar">Taxa forma pgto R$</label>
                    <input onkeyup="totalizar()" type="text" class="form-control" name="taxa" id="taxa_forma_pgto_baixar">
                </div>
      
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="data_pgto_baixar2">Data da baixa</label>
                    <input type="date" class="form-control" name="data_pgto" id="data_pgto_baixar" value="<?= $today->format('Y-m-d') ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="subtotal_baixar">Subtotal</label>
                    <input readonly type="text" class="form-control" name="subtotal" id="subtotal_baixar">
                    <input type="hidden" name="_csrf_token" value="<?= $csrf ?>" />
                </div>
            </div>
        
        </div>
        <div class="modal-footer gap-2">
            <button id="btn_baixar_parcela" type="submit" class="btn btn-success">BAIXAR</button>
            <span class="btn btn-secondary" data-dismiss="modal">FECHAR</span>
        </div>
    </form>        
    </div>
  </div>
</div>

<script>

    const totalizar = ()=>{
        const valor = Number($("#valor_baixar").val().replace(",", "."));
        const juros = Number($("#juros_baixar").val().replace(",", "."));
        const multa = Number($("#multa_baixar").val().replace(",", "."));
        const taxa = Number($("#taxa_forma_pgto_baixar").val().replace(",", "."));
        const desconto = Number($("#desconto_baixar").val().replace(",", "."));


        if(isNaN(valor) || isNaN(juros) ||isNaN(multa) ||isNaN(taxa) ||isNaN(desconto)){
            notyf.error("Digite um valor numérico válido.");
        }

        if(isNaN(valor)) return;

        if(isNaN(multa)) multa.val(0.00);

        if(isNaN(juros)) juros.val(0.00);

        if(isNaN(taxa)) taxa.val(0.00);

        if(isNaN(desconto)) desconto.val(0.00);

        const resultado = Number((valor - desconto) + (multa + taxa + juros)).toFixed(2);

        $("#subtotal_baixar").val(resultado);
    }

    $("#forma_pgto_baixar").on("change", (e)=>{
        const id = $("#forma_pgto_baixar").val();
        if(id){
            $.ajax({
                url: `<?= route("/api/formaspagamento/select") ?>/${id}`,
                processData: false,
                contentType: false,
                cache: false,
                success:(res)=>{
                    try{
                        const json = JSON.parse(res);
                        if(!json.error){
                            $("#taxa_forma_pgto_baixar").val(json.data.taxa);
                            totalizar()
                        }else{
                            notyf.error(json.message);
                        }
                    }catch(err){
                        console.log(err);

                        notyf.error(res.responseText);
                    }
                },
                error: (xhr, status, error)=>{
                    notyf.error("Erro ao procurar a forma de pagamento.");
                }
            })
        }

    })

    $("#baixarParcelaForm").submit((e)=>{
        e.preventDefault();
        const data = new FormData(e.target);
        const url = e.target.action;
        const btnBaixar = $("#btn_baixar_parcela")
        $(btnBaixar).attr('disabled', true);
        $.ajax({
            url: url,
            method:"POST",
            processData: false,
            cache:false,
            contentType:false,
            data: data,
            success: (response)=>{
                console.log(response)
                try{
                    const result = JSON.parse(response);
                    if(result.error == true){
                        const { issues } = result;
                        setErrorMessages(issues, '_baixar');
                        notyf.error(result.message);
                    }else{
                        notyf.success(result.message)
                        listarContasReceber(data_ini, data_fim, situacao);
                        $("#baixarParcelaModal").modal("hide")
                    }
                    $(btnBaixar).attr('disabled', false);

                }catch(err){
                    console.log(err)
                    $(btnBaixar).attr('disabled', false);

                }
                $(btnBaixar).attr('disabled', false);
            },
            error: (xhr, status, err)=>{
                console.log(xhr.responseText)
                $(btnBaixar).attr('disabled', false);
            }
        });
    })
    $("#baixarParcelaModal").on("hidden.bs.modal", ()=>{
        clearErrorMessages(); 

    })
</script>