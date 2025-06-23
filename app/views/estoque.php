<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
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
        <h2>Gerenciar Estoque</h2>

        <!-- Botão para Adicionar Produto -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#adicionarprodutomodal">
            Adicionar Produto
        </button>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Imagem</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (!empty($produtos)) {
                    foreach ($produtos as $produto) {

                        $fotoBlob = $produto['foto'];
                        $foto = base64_encode($fotoBlob);

                        $valor = number_format($produto['valor_un'], 2, ',', '.');

                        echo "<tr>
                                <input type='hidden' name='produtos[]' value='{$produto['id_estoque']}'>
                                <td>{$produto['nome']}</td>
                                <td>
                                    <img src='data:image/png;base64," . $foto . "' width='70' height='auto'>
                                </td>
                                <td>{$produto['quantidade']}</td>
                                <td>R$ {$valor}</td>
                                <td>{$produto['descricao']}</td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal'
                                        data-bs-target='#editarprodutomodal'
                                        data-id='{$produto['id_estoque']}'
                                        data-nome='{$produto['nome']}'
                                        data-quantidade='{$produto['quantidade']}'
                                        data-valor_un='{$produto['valor_un']}'
                                        data-descricao='{$produto['descricao']}'>
                                        Editar
                                    </button>

                                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal'
                                        data-bs-target='#excluirprodutomodal'
                                        data-id='{$produto['id_estoque']}'
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
        <div class="modal fade" id="adicionarprodutomodal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="adicionarprodutomodal">Adicionar Produto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="adicionar@estoque" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="adicionar">

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Produto</label>
                                <input type="text" name="nome" id="nome" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Imagem do Produto</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="quantidade" class="form-label">Quantidade</label>
                                <input type="number" name="quantidade" id="quantidade" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="valor_un" class="form-label">Valor Unitário</label>
                                <input type="text" name="valor_un" id="valor_un" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea name="descricao" id="descricao" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Adicionar Produto</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="editarprodutomodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editarprodutomodal">Editar Produto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="editar@estoque" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="editar">
                            <input type="hidden" name="id_estoque" value="">

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
                                <label for="quantidade" class="form-label">Quantidade</label>
                                <input type="number" name="quantidade" id="quantidade" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="valor_un" class="form-label">Valor Unitário</label>
                                <input type="text" name="valor_un" id="valor_un" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea name="descricao" id="descricao" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
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
        // Formata o valor unitário para exibição com vírgula
        document.getElementById('valor_un').addEventListener('input', function(e) {
            let value = e.target.value;
            // Remove qualquer caractere que não seja número, ponto ou vírgula
            value = value.replace(/[^\d,.]/g, '');
            // Substitui vírgula por ponto para cálculo
            let numericValue = value.replace(',', '.');
            // Verifica se é um número válido
            if (!isNaN(numericValue)) {
                // Formata para exibição com vírgula
                e.target.value = value;
            }
        });

        // Formata o valor unitário no modal de edição
        document.getElementById('editarprodutomodal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id_estoque = button.getAttribute('data-id');
            var nome = button.getAttribute('data-nome');
            var quantidade = button.getAttribute('data-quantidade');
            var valor_un = button.getAttribute('data-valor_un');
            var descricao = button.getAttribute('data-descricao');

            // Formata o valor unitário para exibição com vírgula
            valor_un = valor_un.replace('.', ',');

            var modal = this;
            modal.querySelector('input[name="id_estoque"]').value = id_estoque;
            modal.querySelector('input[name="nome"]').value = nome;
            modal.querySelector('input[name="quantidade"]').value = quantidade;
            modal.querySelector('input[name="valor_un"]').value = valor_un;
            modal.querySelector('textarea[name="descricao"]').value = descricao;
        });

        // Preencher os dados do modal de excluir
        document.getElementById('excluirprodutomodal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Botão que acionou o modal
            var id_estoque = button.getAttribute('data-id');
            var nome = button.getAttribute('data-nome');

            var modal = this;
            modal.querySelector('#produtoNomeExcluir').textContent = "Deseja realmente excluir o produto: '" + nome + "' ?";
            var confirmButton = modal.querySelector('#btnConfirmarExclusao');
            confirmButton.href = "excluir@estoque?action=excluir&estoque=" + id_estoque;
        });
    </script>

</body>

</html>