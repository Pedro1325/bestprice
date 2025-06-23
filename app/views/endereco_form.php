<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Endereço</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="public/css/endereco.css">
</head>

<body>

    <?php include 'header.html' ?>

    <div class="container">
        <div class="endereco">

            <form action="endereco@cep" method="POST" class="form1">
                <h2>Preencha o campo CEP </h2>
                <div class="cep" style="display: flex;">
                    <label>CEP:</label>
                    <input type="text" name="cep" required maxlength="8" value="<?= $_POST['cep'] ?? '' ?>">
                    <div class="botoes">
                        <button class="bt-buscar" type="submit" style="margin-left: 10px;">Buscar</button>
                    </div>
                </div>
            </form>

            <?php if (!empty($erro))
                echo "<p style='color: red;'>$erro</p>"; ?>

            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
                echo "<p style='color: green;'>Endereço salvo com sucesso!</p>";
            } ?>

            <?php if (!empty($endereco) && !isset($endereco['erro'])): ?>

                <form action="endereco@salvar" method="POST">
                    <div class="form2">
                        <input type="hidden" name="cep" value="<?= htmlspecialchars($_POST['cep']) ?>">
                        <div>
                            <label>Rua:</label>
                            <input type="text" name="rua" required value="<?= htmlspecialchars($endereco['logradouro'] ?? '') ?>">
                        </div>
                        <div>
                            <label>Bairro:</label>
                            <input type="text" name="bairro" required value="<?= htmlspecialchars($endereco['bairro'] ?? '') ?>">
                        </div>
                        <div>
                            <label>Cidade:</label>
                            <input type="text" name="cidade" required value="<?= htmlspecialchars($endereco['localidade'] ?? '') ?>">
                        </div>
                        <div>
                            <label>UF:</label>
                            <input type="text" name="uf" required value="<?= htmlspecialchars($endereco['uf'] ?? '') ?>">
                        </div>
                        <div>
                            <label>Número:</label>
                            <input type="text" name="numero" required>
                        </div>
                        <div>
                            <label>Complemento:</label>
                            <input type="text" name="complemento">
                        </div>
                    </div>
                    <div class="bt-submit">
                        <button class="bt-salvar" type="submit">Salvar Endereço</button>
                    </div>
                </form>
            <?php endif; ?>
            <a href="perfil"><button class="bt-voltar">Voltar</button></a>
        </div>
    </div>

    <?php include 'footer.html' ?>

</body>

</html>