

const botoes = document.querySelectorAll(".botoes-size button");

botoes.forEach(botao => {
    botao.addEventListener("click", () => {
        // Remove a classe "ativo" de todos os botões
        botoes.forEach(btn => btn.classList.remove("ativo"));

        // Adiciona a classe "ativo" apenas ao botão clicado
        botao.classList.add("ativo");
    });
});