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


const limparCampos = (form)=>{
    $(form).find("input, textarea, select").not('[name="_csrf_token"]').val("") // Limpa os valores
    $(form).find("input:checkbox, input:radio").not('[name="_csrf_token"]').val("").prop("checked", false); // desmarca checkboxes e radios
}

const inserir = ()=>{
    $("#mensagem").text("");
    $("#titulo_inserir").text("Inserir registro");
    $("#modalForm").modal("show");
    $("#modalForm #form").attr("action", "../api/usuarios/insert")
    limparCampos($("#modalForm"));
}


const messageClose = (e)=>{
    e.parentElement.remove()    
}

const clearErrorMessages = ()=>{
    const allInputs = document.querySelectorAll("input, select, textarea");

    allInputs.forEach((input) => {
        const container = input.parentElement;
        const existingMessage = container.querySelector(".container-message");
        if (existingMessage) {
            existingMessage.remove();
        }
    });
}

const setErrorMessages = (issues)=>{


    // 1. Limpa todos os erros anteriores
    clearErrorMessages();

    for(let issue in issues){
        
        const input = document.getElementById(issue);
        if (!input) continue;

        const container = input.parentElement;

        const existingMessage = container.querySelector(".container-message");

        if(existingMessage){
            existingMessage.remove();
        }

        const containerMessage = document.createElement("div");
        containerMessage.className = "container-message d-flex flex-column"
        containerMessage.style.display = "flex";
        containerMessage.style.flexDirection = "column";


        for(let field in issues[issue]){
            const messageDiv = document.createElement("div");
            messageDiv.style.display = "flex";
            messageDiv.style.justifyContent = "space-between";
            messageDiv.style.alignItems = "center";

            messageDiv.innerHTML = `
                <span> ${issues[issue][field]} </span>
                <span style="cursor:pointer;" class="cursor-pointer" onclick="messageClose(this)">X</span>
            `
            containerMessage.appendChild(messageDiv)

        }

        container.appendChild(containerMessage);
    }
}


const onSubmit = (e)=>{
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
            const response = JSON.parse(data);
            console.log(response);
            if(response.error == false){
                $("#mensagem").text(response.message);
                $("#btn-fechar").click();
                listar()
                clearErrorMessages(); 
                limparCampos($("#modalForm"));
            }else{
                if(response.issues){
                    const { issues } = response;
                    setErrorMessages(issues);
                }
                $("#mensagem").addClass("text-danger");
                $("#mensagem").text(response.message);
            }
        },
        error:(xhr, status, error)=>{
            $("#mensagem").text(xhr.responseText);
        }
        
    })

}


const onDelete = (url)=>{
    $.ajax({
        url: url,
        type: "GET",
        processData: false,
        contentType: false,
        cache: false,
        success: (response)=>{
            $("#mensagem-excluir").text(response.message);
            listar()

        },
        error:(xhr, status, error)=>{
            $("#mensagem-excluir").text(xhr.responseText)
        }
    })
}


$("#form").submit(function(e){
    e.preventDefault();
    onSubmit(e)
})

$("#modalForm").on("hidden.bs.modal", clearErrorMessages);