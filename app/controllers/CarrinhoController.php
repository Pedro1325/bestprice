<?php

require_once 'config/database.php';
require_once 'app/models/CarrinhoModel.php';
require_once 'app/models/UserModel.php';

class CarrinhoController
{
    private $carrinhoModel;
    private $userModel;
    public function __construct()
    {
        $this->carrinhoModel = new CarrinhoModel();
        $this->userModel = new UserModel();
    }

    public function verificaSessao()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            session_abort();
            $this->index();
        } else {
            header("Location: perfil");
            exit();
        }
    }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit;
        }

        $itens = $this->carrinhoModel->listarCarrinho($_SESSION['user_id']);
        $enderecos = $this->userModel->buscaEnderecos($_SESSION['user_id']);
        include 'app/views/carrinho.php';
    }

    public function adicionar()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_estoque = $_POST['id_estoque'];
            $quantidade = $_POST['quantidade'];

            if ($this->carrinhoModel->adicionar($_SESSION['user_id'], $id_estoque, $quantidade)) {
                header('Location: carrinho');
                exit;
            } else {
                $_SESSION['erro'] = "Erro ao adicionar item ao carrinho. Verifique se há estoque suficiente.";
                exit;
            }
        }
    }

    public function atualizar()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_pedido = $_POST['id_pedido'];
            $quantidade = $_POST['quantidade'];

            if ($this->carrinhoModel->atualizarQuantidade($id_pedido, $quantidade)) {
                header('Location: carrinho');
                exit;
            } else {
                $_SESSION['erro'] = "Erro ao atualizar quantidade. Verifique se há estoque suficiente.";
                header('Location: carrinho');
                exit;
            }
        }
    }

    public function remover()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit;
        }

        if (isset($_GET['id'])) {
            $id_pedido = $_GET['id'];

            if ($this->carrinhoModel->remover($id_pedido)) {
                header('Location: carrinho');
                exit;
            } else {
                $_SESSION['erro'] = "Erro ao remover item do carrinho";
                header('Location: carrinho');
                exit;
            }
        }
    }

    public function finalizar()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit;
        }

        if ($this->carrinhoModel->finalizarPedidos($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Pedido finalizado com sucesso!']);
            exit;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Erro ao finalizar pedido']);
            exit;
        }
    }
}
