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

const setErrorMessages = (issues, prefix = '')=>{


    // 1. Limpa todos os erros anteriores
    clearErrorMessages();

    for(let issue in issues){
        
        const input = document.getElementById(issue+prefix);
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