<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Best Price - Premium Shopping Experience</title>
    <link rel="stylesheet" href="public/css/produto.css">
    <script src="public/js/menu.js" defer></script>
</head>

<body>

    <?php include("header.html"); ?>
    <?php
    if (!isset($estoques) || empty($estoques)) {
        echo "<p>Produto não encontrado.</p>";
        return;
    }
    ?>

    <div class="container">
        <div class="produto">
            <div id="carousel" class="img-box">
                <div class="carousel-inner">
                    <?php
                    foreach ($estoques as $estoque) {
                        $fotos[$estoque['id_estoque']] = base64_encode($estoque['foto']);
                        echo "<div class='carousel-item'>
                                    <img class='carousel-img' src='data:image/png;base64," . $fotos[$estoque['id_estoque']] . "'>
                                </div>";
                    }
                    ?>
                </div>
                <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                <button class="next" onclick="moveSlide(1)">&#10095;</button>
            </div>
            <div class="produto-info">
                <h2><?php echo "{$produto['nome']}"; ?></h2>

                <p id="itemPreco" class="preco"><?php echo 'R$ ' . $estoque['valor_un']; ?></p>
                <p class='descricao'><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
                <hr>
                <div class="colours">
                </div>
                <p>Variação:</p>
                <div class="botoes-size">
                    <?php
                    $precos = [];
                    $index = 0;
                    foreach ($estoques as $estoque) {
                        $precos[$estoque['id_estoque']] = $estoque['valor_un'];
                        echo "<button type='button' value='{$estoque['id_estoque']}' data-index='{$index}' onclick='atualizarPreco({$estoque['id_estoque']}, {$index})'>{$estoque['descricao']}</button>";
                        $index++;
                    }
                    ?>
                </div>
                <p class="quant">Quantidade:</p>
                <div class="quantity-container">
                    <button class="btn" type="button" onclick="decrease()">−</button>
                    <input class="quantity" id="quantity" type="number" value="1"></input>
                    <button class="btn" type="button" onclick="increase()">+</button>
                </div>
                <div class="botoes">
                    <button class="bt-carrinho" onclick="adicionarAoCarrinho()">Adicionar ao Carrinho</button>
                    <button class="buy" onclick="adicionarAoCarrinho()">Comprar</button>
                </div>
                <div class="extra-infos">
                    <div class="frete-gratis">
                        <div>
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <h3>Frete Grátis</h3>
                            <a href="">Insira seu endereço para completar sua compra. </a>
                        </div>
                    </div>
                    <hr>
                    <div class="reembolso">
                        <div>
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <div>
                            <h3>Pedir Reembolso</h3>
                            <p>Até 30 dias para solicitação do reembolso.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php include("footer.html"); ?>

    <script>
        const botoes = document.querySelectorAll(".botoes-size button");
        const carouselInner = document.querySelector('.carousel-inner');

        botoes.forEach(botao => {
            botao.addEventListener("click", () => {
                // Remove a classe "ativo" de todos os botões
                botoes.forEach(btn => btn.classList.remove("ativo"));

                // Adiciona a classe "ativo" apenas ao botão clicado
                botao.classList.add("ativo");
            });
        });

        // Estoque e preços das variações
        const estoque = <?php echo json_encode(array_column($estoques, 'quantidade', 'id_estoque')); ?>;
        const precos = <?php echo json_encode(array_column($estoques, 'valor_un', 'id_estoque')); ?>;
        const quantidadeElemento = document.getElementById('quantity');

        quantidadeElemento.addEventListener('input', ajustarQuantidade);

        let estoqueAtual = Object.keys(estoque)[0]; // Define um estoque inicial
        document.addEventListener('DOMContentLoaded', () => {
            atualizarPreco(estoqueAtual, 0);
        });

        function atualizarPreco(id_estoque, index) {
            const precoElemento = document.getElementById('itemPreco');
            precoElemento.textContent = `R$ ${parseFloat(precos[id_estoque]).toFixed(2)}`;
            estoqueAtual = id_estoque; // Atualiza a variação selecionada
            
            // Atualiza a imagem do carrossel
            carouselInner.style.transform = `translateX(${-index * 100}%)`;
            
            ajustarQuantidade();
        }

        function ajustarQuantidade() {
            let quantidade = parseInt(quantidadeElemento.value);
            let maxQuantidade = estoque[estoqueAtual];

            if (quantidade > maxQuantidade) {
                quantidadeElemento.value = maxQuantidade;
            }

            if (quantidade < 1) {
                quantidadeElemento.value = 1;
            }

            if (quantidadeElemento.value == '' || quantidadeElemento.value == null) {
                quantidadeElemento.value = 1;
            }
        }

        function increase() {
            let quantidade = parseInt(quantidadeElemento.value);
            let maxQuantidade = estoque[estoqueAtual];
            if (quantidade < maxQuantidade) {
                quantidadeElemento.value = quantidade + 1;
            }
        }

        function decrease() {
            let quantidade = parseInt(quantidadeElemento.value);
            if (quantidade > 1) {
                quantidadeElemento.value = quantidade - 1;
            }
        }

        let index = 0; // Índice da imagem atual

        function moveSlide(step) {
            const slides = document.querySelectorAll('.carousel-item');
            index += step;

            // Se o índice ultrapassar os limites, volta para o começo ou para o final
            if (index >= slides.length) {
                index = 0;
            } else if (index < 0) {
                index = slides.length - 1;
            }

            // Ajusta a posição do carrossel
            const carouselInner = document.querySelector('.carousel-inner');
            carouselInner.style.transform = `translateX(${-index * 100}%)`;
        }

        // Inicializa o carrossel mostrando a primeira imagem
        document.addEventListener('DOMContentLoaded', () => {
            moveSlide(0);
        });

        function adicionarAoCarrinho() {
            const quantidade = document.getElementById('quantity').value;
            const idEstoque = estoqueAtual;

            // Criar um formulário dinâmico
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'carrinho@adicionar';

            // Adicionar campos ocultos com os dados
            const quantidadeInput = document.createElement('input');
            quantidadeInput.type = 'hidden';
            quantidadeInput.name = 'quantidade';
            quantidadeInput.value = quantidade;

            const idEstoqueInput = document.createElement('input');
            idEstoqueInput.type = 'hidden';
            idEstoqueInput.name = 'id_estoque';
            idEstoqueInput.value = idEstoque;

            form.appendChild(quantidadeInput);
            form.appendChild(idEstoqueInput);

            // Adicionar o formulário ao corpo do documento e enviar
            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <script src="produto.js"></script>
</body>

</html>