$(document).ready(()=>{
    listar();
});

const listar = ()=>{
    $.ajax({
        url: "../api/usuarios",
        method: "GET",
        dataType: "html",
        success: (result)=>{
            $("#listar").html(result);
            $("#mensagem-excluir").remove();
        }
    });
}

const inserir = ()=>{
    $("#mensagem").text("");
    $("#titulo_inserir").text("Inserir registro");
    $("#modalForm").modal("show");
    limparCampos();
}