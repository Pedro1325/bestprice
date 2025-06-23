let btnMenu = document.getElementById('btn-menu')
let menu = document.getElementById('menu-mobile')
let overlay = document.getElementById('overlay-menu')

btnMenu.addEventListener('click', () => {
    menu.classList.add('abrir-menu')
})


menu.addEventListener('click', () => {
    menu.classList.remove('abrir-menu')
})

overlay.addEventListener('click', () => {
    menu.classList.remove('abrir-menu')
})

document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.getElementById("user-icon");
    const userDropdown = document.getElementById("user-dropdown");

    // Exibe ou esconde o dropdown ao clicar no ícone
    userIcon.addEventListener("click", function (event) {
        // Impede a propagação para o evento document
        event.stopPropagation();

        // Alterna o display do dropdown
        userDropdown.style.display = userDropdown.style.display === "block" ? "none" : "block";
    });

    // Fecha o dropdown ao clicar fora
    document.addEventListener("click", function (event) {
        // Verifica se o clique não foi nem no ícone nem no dropdown
        if (!userIcon.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.style.display = "none";
        }

    });
    const botoes = document.querySelectorAll(".user-icon");

    botoes.forEach(botao => {
        botao.addEventListener("click", (event) => {

            // Adiciona a classe "ativo" apenas ao botão clicado
            botao.classList.add("ativo1");
        });
    });

    // Adiciona um event listener no document para detectar cliques fora do botão
    document.addEventListener("click", () => {
        // Remove a classe "ativo" de todos os botões
        botoes.forEach(botao => {
            botao.classList.remove("ativo1");
        });
    });
});
