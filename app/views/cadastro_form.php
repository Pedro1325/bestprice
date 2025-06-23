<!DOCTYPE html>
<html lang="pt-BR">

<head>
<!--     Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <!-- Fonte Personalizada   -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<!--     Estilo Pagina de cadastro  -->
    <link rel="stylesheet" href="public\css\cadastro.css">
</head>

<body>

    <!-- Cabeçalho / NavBar -->
    <?php include 'header.html' ?>

    <div class="container">
        <img src="public/img/Logotipo moderno minimalista azul marinho para ecommerce.png"
            style="width: 300px; height: 250px;" alt="Cart Logo">
        <div class="form-container">
            <div class="logo">
            </div>
            <div class="form-box">
                <h3>Crie uma conta</h3>
                <p>Insira seus detalhes abaixo</p>

                <?php if (isset($error) && $error != ""): ?>
                    <p class="error" style="color: red;"><?= htmlspecialchars($error); ?></p>
                <?php endif; ?>
        <!--Formulario De Cadstro  -->
                <form id="registerForm" action="cadastro" method="POST" class="form-box">
                    <input type="text" name="nome" placeholder="Nome" required value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
                    <input type="email" name="email" placeholder="Email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <input type="text" name="telefone" placeholder="Telefone" value="<?= isset($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : ''; ?>">
                    <input type="password" name="senha" placeholder="Senha" required>
                    <input type="password" name="confirm_senha" placeholder="Confirme sua Senha" required>
                    <button type="submit">Cadastrar</button>

                </form>

                <p class="login-footer">Já tem uma conta? <a href="login" style="color: lightgreen;">Entre</a></p>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <?php include 'footer.html' ?>

</body>

</html>
