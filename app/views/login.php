<div id="app" class="bg-white flex flex-col justify-center items-center rounded w-96 p-4">

    <img 
        src="<?= asset("/img/logo.jpeg") ?>"
        alt="Logo da escola itep"
        class="w-32 "
    />

    <form class=" w-full flex flex-col gap-8" method="POST" action="<?= BASE_URL ?>/login">

        <div class="flex flex-col gap-4">
            <div class="flex flex-col flex-1">
                <label for="email" class="text-gray-600">E-mail:</label>
                <input  id="email" type="email" name="email" value="<?= getOld("email.old") ?>" class="outline-none  border-b-1 border-orange-500 px-2 py-1" placeholder="Digite seu e-mail">
      
                <?= getFlash("email.required", true) ?>
                <?= getFlash("email.notNull", true) ?>
            </div>

            <div class="flex flex-col flex-1">
                <label for="senha" class="text-gray-600">Senha:</label>
                <input id="senha"  type="password" name="senha" value="" class="outline-none  border-b-1 border-orange-500 px-2 py-1" placeholder="Digite sua senha">
                <?= getFlash("senha.required", true) ?>
                <?= getFlash("senha.notNull", true) ?>

            </div>
        </div>

        <input type="hidden" name="_csrf_token" value="<?= $token ?>">

        <button class="cursor-pointer bg-gray-800 transition-all rounded outline-none border-none py-2 px-8 text-white  hover:bg-orange-500">Acessar</button>
    </form>
    <div @click="abrirModal" id="" class="d-block cursor-pointer mt-4">
        <p class="text-blue-700">Recuperar senha</p>
    </div>

<transition name="fade">
    
    <div v-if="modalAberto" id="recuperar-senha" @click.self="fecharModal" class="bg-[rgba(0,0,0,0.5)] p-2 absolute w-full h-full backdrop-blur-sm transition-all flex flex-col justify-center items-center" >

        <div class="bg-white p-4 w-full sm:max-w-96 h-auto rounded">
            <div class="flex border-b-2 border-b-gray-300 p-2 justify-between items-center">
                <h1 class="text-xl text-gray-500 font-thin">Recuperar senha</h1>
                <span @click="fecharModal" class="cursor-pointer text-xl">X</span>
            </div>
            <transition name="scale">
            <div class="flex flex-1  flex-col mt-6">
                <form @submit.prevent="enviarFormulario" id="recuperar-senha-form" method="POST" action="<?= route("/api/recuperarsenha") ?>" class="flex h-full flex-col gap-4">
                    <div id="mensagem" v-if="mensagem" class="text-sm text-red-600">
                        {{ mensagem }}
                    </div>
                    <div class="flex flex-col flex-1">
                        <label for="" class="text-gray-600 font-bold">E-mail:</label>
                        <input ref="emailInput" type="text" name="email" value="" class="outline-none border-b-1 border-orange-500 px-2 py-1" placeholder="Digite seu e-mail">
                    </div>
                    
                    <div id="issues" v-if="errors.email" class="text-sm flex flex-col gap-1 text-red-600">
                        <div v-for="(msg, index) in errors.email" :key="index" class="">
                            {{ msg }}
                        </div>
                    </div>

                    <button type="submit" class="cursor-pointer bg-gray-800 transition-all rounded outline-none border-none py-2 px-8 text-white  hover:bg-orange-500">
                        Recuperar
                    </button>

                </form>
            </div>
       
            </transition>
       

        </div>

    </div>

</div>
</transition>


  <style>
    /* Fade (usado no backdrop) */
    .fade-enter-active,
    .fade-leave-active {
      transition: opacity 0.3s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
      opacity: 0;
    }

    /* Scale (usado no modal) */
    .scale-enter-active,
    .scale-leave-active {
      transition: all 0.3s ease;
    }

    .scale-enter-from,
    .scale-leave-to {
      transform: scale(0.95);
      opacity: 0;
    }
  </style>

<script>

    const { createApp, ref, nextTick } = Vue;

    createApp({
        setup(){
            const modalAberto = ref(false);
            const emailInput = ref(null);
            const mensagem = ref('');
            const errors = ref({});

            const abrirModal = async()=>{
                modalAberto.value = true;
                await nextTick(); // Espera o DOM atualizar
                emailInput.value?.focus();
            }
            const fecharModal = ()=>{
                modalAberto.value = false;
            }

            const enviarFormulario = async()=>{
                const email = emailInput.value?.value
                errors.value = {} // Limpa os erros anteriores
                mensagem.value = "Aguarde..."; // Limpa a mensagem geral
                try{
                    const formData = new FormData();
                    formData.append("email", email);
                    const response = await fetch("/api/recuperarsenha",{
                        method: "POST",
                        body: formData
                    })
                    const result = await response.json();
                 
                    if(response.ok && !result.error){
                        mensagem.value = result.message || "E-mail enviado com sucesso!";
                        emailInput.value.value = "";
                    }else{
                        mensagem.value = result.message || "Erro ao enviar o e-mail.";

                        //captura e exibe os issues
                        if(result.issues && result.issues.email){
                            const mensagemEmail = Object.values(result.issues.email);
                            errors.value.email = mensagemEmail;
                        }
                    }
                    
                }catch(err){
                    console.error("Erro na requisição:", err);
                    mensagem.value = "Erro inesperado ao enviar o e-mail.";
                }

            }

            return {
                modalAberto,
                emailInput,
                abrirModal,
                fecharModal,
                enviarFormulario,
                mensagem,
                errors,
            }
        }
 
    }).mount("#app");

   

</script>