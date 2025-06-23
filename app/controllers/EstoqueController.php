<?php

require_once 'config/database.php';
require_once 'app/models/EstoqueModel.php';

class EstoqueController
{

    private $estoqueModel;

    public function __construct()
    {
        $this->estoqueModel = new EstoqueModel();
    }

    public function exibirEstoque()
    {
        $produtos = $this->estoqueModel->listarEstoque();
        include 'app\views\estoque.php';
    }

    public function adicionarEstoque()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'adicionar') {
            $nome = $_POST['nome'];
            $foto = $_FILES['foto']['tmp_name'];
            $quantidade = $_POST['quantidade'];
            $valor_un = $_POST['valor_un'];
            $descricao = $_POST['descricao'];

            // Chama a função para adicionar produto ao estoque
            if ($this->estoqueModel->adicionar($nome, $foto, $quantidade, $valor_un, $descricao)) {
                header('Location: estoque');
            } else {
                echo "Erro ao adicionar produto ao estoque.";
            }
        } else {
            echo "metodo nao encontrado";
            exit;

        }

    }

    public function editarEstoque()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'editar') {
            $id_estoque = $_POST['id_estoque'];
            $nome = $_POST['nome'];
            $quantidade = $_POST['quantidade'];
            $valor_un = $_POST['valor_un'];
            $descricao = $_POST['descricao'];
            $foto = $_FILES['foto']['tmp_name'];
        
            if ($this->estoqueModel->atualizar($id_estoque, $nome, $foto, $quantidade, $valor_un, $descricao)) {
                header('Location: estoque');
                exit();
            } else {
                echo "Erro ao atualizar o produto.";
            }
        }
    }
    
    public function desvincularEstoque()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'desvincular') {
            $id_estoque = $_GET['id_estoque'];
        
            if ($this->estoqueModel->desvincular($id_estoque)) {
                header('Location: gestao-produto');
                exit();
            } else {
                echo "Erro ao atualizar o produto.";
            }
        }
    }

    public function vincularEstoque()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_produto = isset($_POST['id_produto']) ? $_POST['id_produto'] : null;
            $estoques = $_POST['estoques'];

            if ($this->estoqueModel->vincular($id_produto, $estoques)) {
                header('Location: gestao-produto');
                exit();
            } else {
                echo "Erro ao atualizar o produto.";
            }
        }
    }

    public function excluirEstoque()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'excluir') {
            $id_estoque = $_GET['estoque'];

            if ($this->estoqueModel->excluir($id_estoque)) {
                header('Location: estoque');
            } else {
                echo "Erro ao excluir produto.";
            }
        }
    }

}

?>