<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>

    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
   
    <!-- Estilo customizado da tela -->
    <link rel="stylesheet" href="public/css/add-produto.css">
</head>

<body>
     <!-- Inclui o layout da área administrativa -->
    <?php
    $admin = file_get_contents('app/views/admin.php');
    echo $admin;
    ?>

    <section class="conteiner">
        <!-- Formulário principal para adicionar produto -->
        <form class="addproduto" action="produto@salvar" method="POST" enctype="multipart/form-data">
            <fieldset class="tamanho">
                <legend><b>Adicionar Catálogo</b></legend>
                 <!-- Campo: nome do produto -->

                <div class="form-group">
                    <label for="nome">Nome do produto</label>
                    <input type="text" name="nome" id="nome" required>
                </div>
            <!-- Campo: seleção de categoria -->
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" id="categoria">
                        <?php
                        foreach ($categorias as $categoria) {
                            echo '<option value="' . $categoria['id_categoria'] . '">' . $categoria['nome'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Campo: descrição -->
                <div class="form-group">
                    <label for="descricao">Descrição</label><br>
                    <textarea name="descricao" id="descricao" cols="30" rows="3"></textarea>
                </div>
                <!-- Upload de imagem -->
                <div class="form-group">
                    <label>Adicionar Imagem</label>
                    <input type="file" name="foto" id="foto">
                </div>

                <div class="form-buttons">
                    <input class="btn" type="submit" value="Enviar">

                </div>


            </fieldset>



            <div class="adProduct">

                <!--Botão quando for apertar ele vai abrir o modal-->
                <!--So quando tiver responsivo-->
                <div class="btn3">
                    <button type="button" id="btn2" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Adicionar Catálogo
                    </button>

                </div>
                
                <!-- Cabeçalho da tabela/lista de produtos -->
                <div class="titulo">

                    <label>Adicionar</label>

                    <label class="retirar">Imagem</label>

                    <label>Produto</label>

                    <label>Detalhes</label>

                    <label>Quantidade</label>

                    <label>Preço</label>
                </div>

                <?php

                if (!empty($produtos)) {
                    foreach ($produtos as $produto) {

                        if ($produto['id_produto']) {
                            continue;
                        }

                        $fotoBlob = $produto['foto'];
                        $foto = base64_encode($fotoBlob);

                        $valor = number_format($produto['valor_un'], 2, ',', '.');

                        echo "<div class='box-itens'>

                            <div class='linha'>
                                <input type='checkbox' name='produtos[]' value='{$produto['id_estoque']}'> 
                            </div>

                            <div class='linha' id='retirar'>
                                <img src='data:image/png;base64," . $foto . "' width='70' height='50'>
                            </div>
                                
                            <div class='linha'>
                                <p>{$produto['nome']}</p>
                            </div>

                            <div class='linha'>
                                <p>{$produto['descricao']}</p>
                            </div>
                                                            
                            <div class='linha'>
                                <p>{$produto['quantidade']}</p>
                            </div>

                            <div class='linha'>
                                <p>R$ {$valor}</p>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p>Nenhum produto encontrado no estoque.</p>";
                }
                ?>

            </div>

        </form>

    </section>

    <!-- Modal para o botão  bootstrap-->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <h5 class="modal-title">Adicionar Catálogo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="produto@salvar" method="POST" enctype="multipart/form-data">
                        <legend><b>Adicionar Catálogo</b></legend>

                        <div class="form-group">
                            <label for="nome">Nome do produto</label>
                            <input type="text" name="nome" id="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="categoria">Categoria</label>
                            <select name="categoria" id="categoria">
                                <?php
                                foreach ($categorias as $categoria) {
                                    echo '<option value="' . $categoria['id_categoria'] . '">' . $categoria['nome'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" id="descricao" cols="30" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Adicionar Imagem</label>
                            <input type="file" name="foto" id="foto">
                        </div>

                        <div class="form-buttons">
                            <input class="btn" type="submit" value="Enviar">

                        </div>
                        <?php
     // <!-- Produtos do estoque (igual ao de fora do modal) -->
                        if (!empty($produtos)) {
                            foreach ($produtos as $produto) {

                                if ($produto['id_produto']) {
                                    continue;
                                }

                                $fotoBlob = $produto['foto'];
                                $foto = base64_encode($fotoBlob);

                                $valor = number_format($produto['valor_un'], 2, ',', '.');

                                echo "<div class='box-itens1'>

                            <div class='linha'>
                                <input type='checkbox' name='produtos[]' value='{$produto['id_estoque']}'> 
                            </div>

                            <div class='linha' id='retirar'>
                                <img src='data:image/png;base64," . $foto . "' width='70' height='50'>
                            </div>
                                
                            <div class='linha'>
                                <p>{$produto['nome']}</p>
                            </div>

                            <div class='linha'>
                                <p>{$produto['descricao']}</p>
                            </div>
                                                            
                            <div class='linha'>
                                <p>{$produto['quantidade']}</p>
                            </div>

                            <div class='linha'>
                                <p>R$ {$valor}</p>
                            </div>
                        </div>";
                            }
                        } else {
                            echo "<p>Nenhum produto encontrado no estoque.</p>";
                        }
                        ?>

                    </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
