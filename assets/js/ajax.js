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
        }
    });
}