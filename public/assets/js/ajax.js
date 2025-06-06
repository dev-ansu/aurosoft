
const notyf = new Notyf();

const limparCampos = (form)=>{
    $(form).find("input, textarea, select").not('[name="_csrf_token"]').val("") // Limpa os valores
    $(form).find("input:checkbox, input:radio").not('[name="_csrf_token"]').val("").prop("checked", false); // desmarca checkboxes e radios
}

const inserir = ()=>{
    $("#mensagem").text("");
    $("#titulo_inserir").text("Inserir registro");
    $("#modalForm").modal("show");
    $("#modalForm #form").attr("action", "../api/usuarios/insert")
}

const onSubmit = (e, prefixMessages = '')=>{
    e.preventDefault();
    const url = e.target.action;
    let formData = new FormData(e.target);

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: (data)=>{

            try{
                const json = JSON.parse(data);
                if(json.error == false){
                    notyf.success(json.message)
                    clearErrorMessages(); 
                    listar();
                    if(!url.contains("patch") || !url.contains("update") || !url.contains("put")){
                        limparCampos($("#modalForm"));
                    }
                }else{
                    notyf.error(json.message)
                    if(json.issues){
                    const { issues } = json;
                        setErrorMessages(issues, prefixMessages);
                    }
                    $(`#mensagem${prefixMessages}`).addClass("text-danger");
                    $(`#mensagem${prefixMessages}`).text(json.message);
                }
            }catch(err){
                notyf.error(err.responseText)
            }
        },
        error:(xhr, status, error)=>{
            $(`#mensagem${prefixMessages}`).text(xhr.responseText);
        }
        
    })

}


const showMessage = (message, duration = 5000)=>{
    $("#mensagem-excluir").attr("style", "display:block")
    $("#mensagem-excluir").hide(duration)
    $("#mensagem-excluir").text(message);
}

const onDelete = (url)=>{
    $.ajax({
        url: url,
        type: "GET",
        processData: false,
        contentType: false,
        cache: false,
        success: (response)=>{
            try{
                const json = JSON.parse(response);
                if(json.error == false){
                    notyf.success(json.message)
                }else{
                    notyf.error(json.message)
                }
            }catch(err){
                notyf.error(err.responseText)
            }
            showMessage(response.message)
            listar()
        },
        error:(xhr, status, error)=>{
            showMessage(xhr.responseText)
        }
    })
}

const ativar = (url)=>{
        console.log(url);
        $.ajax({
        url: url,
        type: "GET",
        processData: false,
        contentType: false,
        cache: false,
        success: (response)=>{
            try{
                const json = JSON.parse(response);
                if(json.error == false){
                    notyf.success(json.message)
                }else{
                    notyf.error(json.message)
                }
            }catch(err){
                notyf.error(err.responseText)
            }
        },
        error:(xhr, status, error)=>{
            notyf.error(err.responseText)
        }
    })
}


$("#form").submit(function(e){
    e.preventDefault();
    onSubmit(e)
})

$("#form-config").submit(function(e){
    e.preventDefault();
    onSubmit(e, '_sistema')
})


$("#modalForm").on("hidden.bs.modal", ()=>{
    clearErrorMessages()
});


