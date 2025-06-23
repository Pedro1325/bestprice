<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Catalogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>


    <?php
        $admin = file_get_contents('app/views/admin.php');
        echo $admin;
    ?>


    <div class="container mt-5">
        <h2>Editar Paginas de Produto do Catalogo</h2>

        <!-- Botão para Adicionar Produto -->
        <a href="add-produto">
            <button type="button" class="btn btn-success" data-bs-toggle="modal">
                Adicionar Produto
            </button>
        </a>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Imagem</th>
                    <th>Estoques Relacionados</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $categoriasMap = [];
                foreach ($categorias as $categoria) {
                    $categoriasMap[$categoria['id_categoria']] = $categoria['nome'];
                }
                $estoquesMap = [];
                foreach ($estoques as $estoque) {
                    $estoquesMap[$estoque['id_produto']][] = [
                        'id_estoque' => $estoque['id_estoque'],
                        'nome' => $estoque['nome'],
                        'descricao' => $estoque['descricao'],
                        'foto' => $estoque['foto']
                    ];
                }

                if (!empty($produtos) && !empty($categorias)) {
                    foreach ($produtos as $produto) {

                        $nomeCategoria = isset($categoriasMap[$produto['id_categoria']]) ? $categoriasMap[$produto['id_categoria']] : 'Categoria não encontrada';
                        $estoquesMapeados = isset($estoquesMap[$produto['id_produto']]) ? $estoquesMap[$produto['id_produto']] : [];

                        $fotoBlob = $produto['foto'];
                        $foto = base64_encode($fotoBlob);

                        echo "<tr>
                                <input type='hidden' name='produtos[]' value='{$produto['id_produto']}'>
                                <td>{$produto['nome']}</td>
                                <td>
                                    <img src='data:image/png;base64," . $foto . "' width='70' height='auto'>
                                </td>
                                <td class='dropdown'>
                                    <button class='btn btn-success dropdown-toggle w-100' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                                        Clique para ver a lista
                                    </button>
                                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                            <li style='display: flex; justify-content: center; margin-bottom: 10px;'>
                                                <button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#adicionarEstoqueModal' data-id-produto='{$produto['id_produto']}'>
                                                    Adicionar Estoque
                                                </button>
                                            </li>";

                        foreach ($estoquesMapeados as $estoque) {
                            echo "<li>
                                    <div class='dropdown-item' style='display:flex; align-items:center; justify-content:space-between; height:80px; border:solid 1px rgba(0, 0, 0, 0.1); margin:5px 0;'>
                                        <div>
                                            <img style='border-radius:10%;' src='data:image/png;base64," . base64_encode($estoque['foto']) . "' width='70' height='auto'>
                                            <strong>{$estoque['nome']}</strong> - {$estoque['descricao']}
                                        </div>
                                            <a href='desvincula@estoque?action=desvincular&id_estoque={$estoque['id_estoque']}' class='btn btn-danger btn-sm' style='margin-left: 10px;'>
                                                Remover
                                            </a>
                                    </div>
                                </li>";
                        }
                        echo "</ul>
                                </td>
                                <td>{$produto['descricao']}</td>
                                <td>{$nomeCategoria}</td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal'
                                        data-bs-target='#editarprodutomodal'
                                        data-id='{$produto['id_produto']}'
                                        data-nome='{$produto['nome']}'
                                        data-id-categoria='{$produto['id_categoria']}'
                                        data-descricao='{$produto['descricao']}'>
                                        Editar
                                    </button>

                                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal'
                                        data-bs-target='#excluirprodutomodal'
                                        data-id='{$produto['id_produto']}'
                                        data-nome='{$produto['nome']}'>
                                        Excluir
                                    </button>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<p>Nenhum produto encontrado no estoque.</p>";
                }

                ?>

            </tbody>
        </table>

        <div class="modal fade" id="editarprodutomodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editarprodutomodal">Editar Produto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="produto@editar" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="editar">
                            <input type="hidden" name="id_produto" id="id_produto">

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Produto</label>
                                <input type="text" name="nome" id="nome" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Imagem do Produto</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                                <small>Deixe em branco para manter a imagem atual.</small>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea name="descricao" id="descricao" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select name="categoria" id="categoria" class="form-control">
                                    <?php
                                    foreach ($categorias as $categoria) {
                                        $selected = $categoria['id_categoria'] == $produto['id_categoria'] ? 'selected' : '';
                                        echo '<option value="' . $categoria['id_categoria'] . '" ' . $selected . '>' . $categoria['nome'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="adicionarEstoqueModal" tabindex="-1" aria-labelledby="adicionarEstoqueModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adicionarEstoqueModalLabel">Adicionar Estoque</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="adicionarEstoqueForm" action="vincular@estoque" method="POST">
                            <input type="hidden" name="id_produto" id="modalIdProduto">
                            <!-- campo oculto para id_produto -->

                            <!-- Aqui você listaria os produtos do estoque -->
                            <?php
                            if (!empty($estoques)) {
                                foreach ($estoques as $estoque) {
                                    if (!$estoque['id_produto']) {  // Verifica se o estoque não está vinculado a nenhum produto
                            
                                        $fotoBlob = $estoque['foto'];
                                        $foto = base64_encode($fotoBlob);

                                        $valor = number_format($estoque['valor_un'], 2, ',', '.');

                                        echo "<div class='container mt-3'>
                                        <div class='row align-items-center border p-2 mb-3 rounded'>
                                            <div class='col-auto'>
                                                <input type='checkbox' name='estoques[]' value='{$estoque['id_estoque']}'>
                                            </div>
                                            <div class='col-auto'>
                                                <img src='data:image/png;base64,{$foto}' width='70' height='50'>
                                            </div>
                                            <div class='col'>
                                                <p>{$estoque['nome']}</p>
                                            </div>
                                            <div class='col'>
                                                <p>{$estoque['descricao']}</p>
                                            </div>
                                            <div class='col'>
                                                <p>{$estoque['quantidade']}</p>
                                            </div>
                                            <div class='col'>
                                                <p>R$ {$valor}</p>
                                            </div>
                                        </div>
                                    </div>";
                                    }
                                }
                            } else {
                                echo "<p>Nenhum produto encontrado no estoque.</p>";
                            }
                            ?>
                            <!-- Fim da listagem -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Adicionar Estoque</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="excluirprodutomodal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editarprodutomodal">Excluir Produto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 style="text-align: center;" id="produtoNomeExcluir">Deseja realmente excluir o produto?</h5>
                        <div class="botoes-confirm" style="display: flex; justify-content: center; gap:20px;">
                            <a href="#" id="btnConfirmarExclusao" class="btn btn-danger">Sim</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('editarprodutomodal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Botão que acionou o modal
            var id_produto = button.getAttribute('data-id');
            var nome = button.getAttribute('data-nome');
            var descricao = button.getAttribute('data-descricao');
            var id_categoria = button.getAttribute('data-id-categoria');

            var modal = this;
            modal.querySelector('#id_produto').value = id_produto;
            modal.querySelector('#nome').value = nome;
            modal.querySelector('#descricao').value = descricao;
            modal.querySelector('#categoria').value = id_categoria; // Preenche o campo de categoria com o valor correto


        });

        // Preencher os dados do modal de excluir
        document.getElementById('excluirprodutomodal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Botão que acionou o modal
            var id_produto = button.getAttribute('data-id');
            var nome = button.getAttribute('data-nome');

            var modal = this;
            modal.querySelector('#produtoNomeExcluir').textContent = "Deseja realmente excluir o produto: '" + nome + "' ?";
            var confirmButton = modal.querySelector('#btnConfirmarExclusao');
            confirmButton.href = "produto@excluir?action=excluir&produto=" + id_produto;
        });

        document.getElementById('adicionarEstoqueModal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Botão que acionou o modal
            var id_produto = button.getAttribute('data-id-produto'); // Captura o id_produto

            // Preenche o campo oculto com o id_produto
            var modal = this;
            modal.querySelector('#modalIdProduto').value = id_produto;
        });
    </script>

</body>

</html>