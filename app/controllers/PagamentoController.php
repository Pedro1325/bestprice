<?php

require_once 'config/database.php';
require_once 'app/models/CarrinhoModel.php';

class PagamentoController {
    private $carrinhoModel;

    public function __construct() {
        $this->carrinhoModel = new CarrinhoModel();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit;
        }

        // Busca os itens do carrinho do usuário
        $itens = $this->carrinhoModel->listarCarrinho($_SESSION['user_id']);

        if (empty($itens)) {
            header('Location: carrinho');
            exit;
        }

        // Carrega a view de pagamento
        require_once 'app/views/pagamento.php';
    }
}
