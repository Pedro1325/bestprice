<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/login.css">

</head>

<body>

    <!-- Cabeçalho / NavBar -->
    <?php include 'header.html'; ?>

    <div class="container">
        <img src="public/img/Logotipo moderno minimalista azul marinho para ecommerce.png"
            style="width: 300px; height: 250px;" alt="Cart Logo">
        <div class="form-container">
            <div class="logo">
            </div>
            <div class="form-box">
                <h3>Faça seu login</h3>
                <p>Insira seus detalhes abaixo</p>

                <?php if (isset($error) && $error != ""): ?>
                    <p class="error" style="color: red;"><?= htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <form id="loginForm" action="login" method="POST">
                    <input type="email" name="email" placeholder="Email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <input type="password" name="senha" placeholder="Senha" required>
                    <button type="submit">Entrar</button>
                </form>
                <p class="login-footer">Ainda não tem uma conta? <a href="cadastro"
                        style="color: lightgreen;">Cadastre-se</a></p>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <?php include 'footer.html' ?>

</body>

</html>