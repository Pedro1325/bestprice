<?php

require_once 'config/database.php';
require_once 'app/models/CategoriaModel.php';

class CategoriaController
{
    private $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $categorias = $this->categoriaModel->listar();
        include 'app/views/categoria.php';
    }

    public function adicionar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'adicionar') {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];

            if ($this->categoriaModel->adicionar($nome, $descricao)) {
                header('Location: categoria');
                exit();
            } else {
                echo "Erro ao adicionar categoria.";
            }
        }
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'editar') {
            $id_categoria = $_POST['id_categoria'];
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];

            if ($this->categoriaModel->atualizar($id_categoria, $nome, $descricao)) {
                header('Location: categoria');
                exit();
            } else {
                echo "Erro ao atualizar categoria.";
            }
        }
    }

    public function excluir()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'excluir') {
            $id_categoria = $_GET['categoria'];

            if ($this->categoriaModel->excluir($id_categoria)) {
                header('Location: categoria');
                exit();
            } else {
                echo "Erro ao excluir categoria.";
            }
        }
    }
}
