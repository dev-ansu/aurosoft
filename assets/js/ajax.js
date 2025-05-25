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

// const limparCampos = (form)=>{
//     $(form).find("input, textarea, select").val(""); // Limpa os valores
//     $(form).find("input:checkbox, input:radio").prop("checked", false); // desmarca checkboxes e radios
// }

const inserir = ()=>{
    $("#mensagem").text("");
    $("#titulo_inserir").text("Inserir registro");
    $("#modalForm").modal("show");
    // limparCampos($("#modalForm"));
}

$("#form").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url:"../api/usuarios/insert",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: (message)=>{
            $("#mensagem").text("");
            $("#mensagem").removeClass()
            if(message.trim() == "Salvo com sucesso"){
                // $("#btn-fechar").click();
                $("#mensagem").text(message);
                listar()
            }else{
                $("#mensagem").addClass("text-danger");
                $("#mensagem").text(message);
            }
        },
        error:(xhr, status, error)=>{
            
            $("#mensagem").text(xhr.responseText);
        }
        
    })

    
})