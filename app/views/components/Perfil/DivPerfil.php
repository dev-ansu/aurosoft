<div>
<div class="modal-body">
    

        <div class="row">
            <div class="col-md-6">							
                    <label>Nome</label>
                    <p><?php echo @$session->nome ?></p>							
            </div>

            <div class="col-md-6">							
                    <label>Email</label>
                    <p><?php echo @$session->email ?>" </p>					
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">							
                    <label>Telefone</label>
                    <p><?php echo @$session->telefone ?></p>							
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">							
                    <label>Rua</label>
                    <p><?= @$session->rua ?></p>							
            </div>


            <div class="col-md-4">							
                    <label>Número da casa</label>
                    <p><?= @$session->numero ?></p>							
            </div>

            <div class="col-md-4">							
                    <label>Bairro</label>
                    <p><?= @$session->bairro ?></p>						
            </div>
        </div>


        <div class="row">

            <div class="col-md-6">								
                <img src="<?= @$session->foto ? uploaded(@$session->foto):asset("/images/sem-foto.jpg") ?>"  width="80px" id="target-usu">								                
            </div>

            
        </div>
    
    <br>
</div>


</div>