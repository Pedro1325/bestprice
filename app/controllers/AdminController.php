<?php class AdminController
{
    private $userModel;
    private $produtoController;
    private $estoqueController;
    private $dashboardController;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->produtoController = new ProdutoController();
        $this->estoqueController = new EstoqueController();
        $this->dashboardController = new DashboardController();
    }

    public function checkAdminAccess()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit();
        }

        $user_id = $_SESSION['user_id'];

        if ($this->userModel->isAdmin($user_id)) {
            $page = isset($_GET['url']) ? $_GET['url'] : '';

            if (!empty($page)) {
                if ($page === 'add-produto') {
                    $this->produtoController->adicionarCatalogo();
                    exit();
                }
                if ($page === 'gestao-produto') {
                    $this->produtoController->editarCatalogo();
                    exit();
                }
                if ($page === 'estoque') {
                    $this->estoqueController->exibirEstoque();
                    exit();
                }
                if ($page === 'admin') {
                    $this->dashboardController->index();
                    exit();
                }
                include "app/views/{$page}.php";
                exit();
            }
        } else {
            echo "Acesso negado! Você não tem permissões de administrador.";
            exit();
        }
    }
}

?>