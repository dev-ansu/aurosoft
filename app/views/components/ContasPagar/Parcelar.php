<!-- Modal -->
<div class="modal fade" id="parcelarModal" tabindex="-1" role="dialog" aria-labelledby="parcelarModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="parcelarModalTitle">Parcelar conta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="parcelarForm" action="<?= route('/api/contasreceber/parcelar') ?>">
            
            <input type="hidden" id="id_parcelar" name="id">

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="valor_parcelar">Valor</label>
                    <input readonly type="text" id="valor_parcelar" name="valor" class="form-control">                
                </div>
                <div class="form-group col-md-4">
                    <label for="qtd_parcelas">Qtd. parcelas</label>
                    <input type="text" id="qtd_parcelas_parcelar" name="qtd_parcelas" class="form-control">                
                </div>
                <div class="form-group col-md-4">
                    <label for="valor_parcelar">Frequência do parcelamento</label>
                
                    <select name="frequencia" id="frequencia_parcelar" class="form-control">
                        <option value="">Selecione uma frequência</option>
                        <?php
                        foreach($frequencias as $frequencia): ?>
                            <option value="<?= $frequencia->id ?>"><?= $frequencia->frequencia ?> (<?= $frequencia->dias ?>)</option>
                        <?php endforeach; ?>
                    </select>	
                </div>
            </div>

            <input type="hidden" name="_csrf_token" value="<?= $csrf ?>" />
   
        
        </div>
        <div class="modal-footer gap-2">
            <button id="btn_parcelar" type="submit" class="btn btn-success">BAIXAR</button>
            <span class="btn btn-secondary" data-dismiss="modal">FECHAR</span>
        </div>
    </form>        
    </div>
  </div>
</div>

<script>

    $("#parcelarForm").submit((e)=>{
        e.preventDefault();
        const data = new FormData(e.target);
        const url = e.target.action;
        const btnBaixar = $("#btn_parcelar")
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
                        setErrorMessages(issues, '_parcelar');
                        notyf.error(result.message);
                    }else{
                        notyf.success(result.message)
                        listarContasReceber(data_ini, data_fim, situacao);
                        $("#parcelarModal").modal("hide")
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
    $("#parcelarModal").on("hidden.bs.modal", ()=>{
        clearErrorMessages(); 

    })
</script>