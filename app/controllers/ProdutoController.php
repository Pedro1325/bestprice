<?php
require_once 'config/database.php';
require_once 'app\models\ProdutoModel.php';

class ProdutoController
{

    private $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
    }

    public function index()
    {
        $id_produto = $_GET['id'] ?? null;

        if ($id_produto) {
            $produto = $this->produtoModel->buscarProdutoPorId($id_produto);
            $estoques = $this->produtoModel->buscarEstoquePorProduto($id_produto);

            if ($produto || $estoques) {
                include 'app\views\produto.php';
            } else {
                echo "Produto não encontrado.";
            }
        } else {
            echo "ID de produto inválido.";
        }
    }

    public function adicionarCatalogo()
    {
        $produtos = $this->produtoModel->listarEstoque();
        $categorias = $this->produtoModel->listarCategoria();
        include 'app\views\add-produto.php';
    }

    public function editarCatalogo()
    {
        $estoques = $this->produtoModel->listarEstoque();
        $produtos = $this->produtoModel->listarProdutos();
        $categorias = $this->produtoModel->listarCategoria();
        include 'app\views\gestao-produto.php';
    }

    public function salvarProduto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $id_categoria = $_POST['categoria'];
            $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $fotoBinario = file_get_contents($_FILES['foto']['tmp_name']);
            } else {
                $fotoBinario = null;  // No photo uploaded, set as null
            }

            if (isset($_POST['produtos']) && !empty($_POST['produtos'])) {
                $this->produtoModel->adicionarProduto($nome, $id_categoria, $descricao, $fotoBinario);
            } else {
                die("Nenhum item de estoque selecionado");
            }
        }

        header("Location: add-produto");
        exit;
    }

    public function editarProduto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'editar') {
            $id_produto = $_POST['id_produto'];
            $nome = $_POST['nome'];
            $id_categoria = $_POST['categoria'];
            $descricao = $_POST['descricao'];
            $foto = $_FILES['foto']['tmp_name'];


            if ($this->produtoModel->editarProduto($id_produto, $nome, $id_categoria, $descricao, $foto)) {
                header("Location: gestao-produto");
                exit();
            } else {
                echo "Erro ao atualizar o produto.";
            }
        }
    }

    public function excluirProduto()
    { {
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'excluir') {
                $id_produto = $_GET['produto'];

                if ($this->produtoModel->excluir($id_produto)) {
                    header('Location: gestao-produto');
                } else {
                    echo "Erro ao excluir produto.";
                }
            }
        }
    }
}
