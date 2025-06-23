<?php

require_once 'config/database.php';
require_once 'app\models\ProdutoModel.php';
require_once 'app/models/CategoriaModel.php';

class HomeController
{
    private $produtoModel;
    private $categoriaModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->categoriaModel = new CategoriaModel();
    }
    public function index()
    {
        $produtos = $this->produtoModel->listarProdutosComValor();
        $categorias = $this->categoriaModel->listar();
        include 'app/views/home.php';
    }
}

?>