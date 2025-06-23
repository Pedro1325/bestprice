<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
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
        <h2>Gerenciar Categorias</h2>

        <!-- Botão para Adicionar Categoria -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#adicionarcategoriamodal">
            Adicionar Categoria
        </button>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($categorias)) {
                    foreach ($categorias as $categoria) {
                        echo "<tr>
                                <input type='hidden' name='categorias[]' value='{$categoria['id_categoria']}'>
                                <td>{$categoria['nome']}</td>
                                <td>{$categoria['descricao']}</td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal'
                                        data-bs-target='#editarcategoriamodal'
                                        data-id='{$categoria['id_categoria']}'
                                        data-nome='{$categoria['nome']}'
                                        data-descricao='{$categoria['descricao']}'>
                                        Editar
                                    </button>

                                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal'
                                        data-bs-target='#excluircategoriamodal'
                                        data-id='{$categoria['id_categoria']}'
                                        data-nome='{$categoria['nome']}'>
                                        Excluir
                                    </button>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhuma categoria encontrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal Adicionar Categoria -->
        <div class="modal fade" id="adicionarcategoriamodal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="adicionarcategoriamodal">Adicionar Categoria</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="adicionar@categoria" method="POST">
                            <input type="hidden" name="action" value="adicionar">

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome da Categoria</label>
                                <input type="text" name="nome" id="nome" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea name="descricao" id="descricao" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Adicionar Categoria</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Categoria -->
        <div class="modal fade" id="editarcategoriamodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editarcategoriamodal">Editar Categoria</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="editar@categoria" method="POST">
                            <input type="hidden" name="action" value="editar">
                            <input type="hidden" name="id_categoria" value="">

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome da Categoria</label>
                                <input type="text" name="nome" id="nome" class="form-control" required>
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

        <!-- Modal Excluir Categoria -->
        <div class="modal fade" id="excluircategoriamodal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="excluircategoriamodal">Excluir Categoria</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 style="text-align: center;" id="categoriaNomeExcluir">Deseja realmente excluir a categoria?</h5>
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
        // Preencher os dados do modal de edição
        document.getElementById('editarcategoriamodal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id_categoria = button.getAttribute('data-id');
            var nome = button.getAttribute('data-nome');
            var descricao = button.getAttribute('data-descricao');

            var modal = this;
            modal.querySelector('input[name="id_categoria"]').value = id_categoria;
            modal.querySelector('input[name="nome"]').value = nome;
            modal.querySelector('textarea[name="descricao"]').value = descricao;
        });

        // Preencher os dados do modal de excluir
        document.getElementById('excluircategoriamodal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id_categoria = button.getAttribute('data-id');
            var nome = button.getAttribute('data-nome');

            var modal = this;
            modal.querySelector('#categoriaNomeExcluir').textContent = "Deseja realmente excluir a categoria: '" + nome + "' ?";
            var confirmButton = modal.querySelector('#btnConfirmarExclusao');
            confirmButton.href = "excluir@categoria?action=excluir&categoria=" + id_categoria;
        });
    </script>

</body>

</html>