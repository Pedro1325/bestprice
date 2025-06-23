<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Price - Premium Shopping Experience</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public\css\home.css">
</head>

<body>

    <!-- Cabeçalho / NavBar -->
    <?php include 'header.html'; ?>

    <!-- Banner principal -->
    <div class="banner">
        <div class="banner-content">
            <h2>Descubra o Melhor da Tecnologia</h2>
            <p>Produtos premium com preços imbatíveis</p>
            <a href="#products" class="cta-button">Ver Ofertas</a>
        </div>
    </div>


    <!-- Categorias -->
    <div class="categories">
        <?php 
        $categoriaAtual = isset($_GET['categoria']) ? $_GET['categoria'] : null;
        foreach ($categorias as $categoria): 
            $isActive = ($categoriaAtual == $categoria['id_categoria']);
            $href = $isActive ? '?' : '?categoria=' . $categoria['id_categoria'] . '#products';
        ?>
            <a href="<?= $href ?>" class="category <?= $isActive ? 'active' : '' ?>">
                <span><?= htmlspecialchars($categoria['nome']) ?></span>
            </a>
        <?php endforeach; ?>
    </div>


    <!-- Seção de produtos -->
    <main id="products">
        <div style="display: flex; justify-content: center; height: 50px;">
            <h2 class="section-title">Produtos em Destaque</h2>
        </div>
        <!-- Produto 1 -->
        <div class="products">
            <!-- Produto Box -->
            <?php foreach ($produtos as $produto) {

                $fotoBlob = $produto['foto'];
                $foto = base64_encode($fotoBlob);

                echo " 
                    <div class='product-card'>
                        <div class='product-badge'>Novo</div>
                        <img src='data:image/png;base64, {$foto}' alt='{$produto['nome']}'>

                        <div class='product-info'>
                            <h3>{$produto['nome']}</h3>
                            <p class='price'>R$ " . number_format($produto['valor_un'], 2, ',', '.') . "</p>
                            <p class='installments'>{$produto['descricao']}</p>
                            <a href='produto?id={$produto['id_produto']}'>
                                <button class='buy-button'><i class='fas fa-shopping-cart'></i> Comprar</button>
                            </a>
                        </div>
                    </div>"
                ;

            } ?>

        </div>
    </main>


   <!-- Newsletter -->
<section class="newsletter">
  <div class="newsletter-content">
    <h3>Receba Nossas Ofertas</h3>
    <p>Cadastre-se para receber promoções exclusivas</p>
    <form class="newsletter-form" id="newsletterForm">
      <input type="email" id="emailInput" placeholder="Seu melhor e-mail" required>
      <button type="submit">Cadastrar</button>
    </form>
    <p id="formMessage" style="margin-top: 10px; color: green; display: none;"></p>
  </div>
</section>

<!-- Modal com formulário -->
<div id="newsletterModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Dados cadastrados com sucesso</h3>
    <i class="bi bi-check-circle-fill"></i>
  </div>
</div>


    <!-- Rodapé -->
    <?php include 'footer.html' ?>

</body>
<script>
  const modal = document.getElementById("newsletterModal");
  const closeBtn = document.querySelector(".close");
  const form = document.getElementById("newsletterForm");
  const emailInput = document.getElementById("emailInput");
  const formMessage = document.getElementById("formMessage");

  // Fechar modal com o botão X
  closeBtn.onclick = () => {
    modal.style.display = "none";
  };

  // Fechar modal clicando fora
  window.onclick = (event) => {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  // Validação do e-mail e exibição do modal
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const email = emailInput.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailRegex.test(email)) {
      // Esconde mensagem anterior, limpa campo e mostra modal
      formMessage.style.display = "none";
      emailInput.value = "";

      modal.style.display = "block";
    } else {
      formMessage.textContent = "Por favor, insira um e-mail válido.";
      formMessage.style.color = "red";
      formMessage.style.display = "block";
    }
  });
</script>



</html>
