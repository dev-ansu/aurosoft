<?php 
    use app\services\PermissionService;
?>
<?php if(PermissionService::has("perfil")): ?>
<form id="form_perfil">
<div class="modal-body">
    

        <div class="row">
            <div class="col-md-6">							
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome_perfil" name="nome" placeholder="Seu Nome" value="<?php echo @$session->nome ?>" required>							
            </div>

            <div class="col-md-6">							
                    <label>Email</label>
                    <input type="email" class="form-control" id="email_perfil" name="email" placeholder="Seu e-mail" value="<?php echo @$session->email ?>" required>							
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">							
                    <label>Telefone</label>
                    <input type="text" class="form-control" id="telefone_perfil" name="telefone" placeholder="Seu Telefone" value="<?php echo @$session->telefone ?>" required>							
            </div>


            <div class="col-md-4">							
                    <label>Senha</label>
                    <input type="password" class="form-control" id="senha_perfil" name="senha" placeholder="Senha" value="" required>							
            </div>

            <div class="col-md-4">							
                    <label>Confirmar Senha</label>
                    <input type="password" class="form-control" id="senha_conf_perfil" name="senha_conf" placeholder="Confirmar Senha" value="" required>							
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">							
                    <label>Rua</label>
                    <input type="text" class="form-control" id="rua_perfil" name="rua" placeholder="Nome da rua" value="<?= @$session->rua ?>" required>							
            </div>


            <div class="col-md-4">							
                    <label>Número da casa</label>
                    <input type="text" class="form-control" id="numero_perfil" name="numero" placeholder="Número da casa" value="<?= @$session->numero ?>" required>							
            </div>

            <div class="col-md-4">							
                    <label>Bairro</label>
                    <input type="text" class="form-control" id="bairro_perfil" name="bairro" placeholder="Nome do bairro" value="<?= @$session->bairro ?>" required>							
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">							
                    <label>Foto</label>
                    <input type="file" class="form-control" id="foto_perfil" name="foto" value="<?= @$session->foto ? uploaded(@$session->foto):asset("/images/sem-foto.jpg") ?>" onchange="carregarImgPerfil()">							
            </div>

            <div class="col-md-6">								
                <img src="<?= @$session->foto ? uploaded(@$session->foto):asset("/images/sem-foto.jpg") ?>"  width="80px" id="target-usu">								
                
            </div>

            
        </div>
    

    <br>
    <small><div id="mensagem-perfil" align="center"></div></small>
</div>
<?php if(PermissionService::has("api/perfil")): ?>
<div class="modal-footer">    
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>
<?php endif; ?>
</form>
<?php endif; ?>

<?php if(PermissionService::has("api/perfil")): ?>
<script>

    $("#form_perfil").submit((e)=>{
        e.preventDefault();
        const formData = new FormData(e.target);
        $.ajax({
            url: "../api/perfil",
            method: "POST",
            contentType: false,       // Impede que o jQuery defina o contentType
            processData: false,       // Impede que o jQuery processe os dados
            data: formData,
            success: (response)=>{
                const result = JSON.parse(response);
                if(result.error == false){
                    $("#mensagem-perfil").text(result.message);
                    $("#modalPerfil").modal("hide");
                }else{
                    $("#mensagem-perfil").text(result.message)
                    setErrorMessages(result.issues, '_perfil');

                }
            },
            error: (xhr, status, error)=>{
                console.log(xhr.responseText)
            }
        })
    })
</script>
<?php endif; ?>