<?php

class PerfilController
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            session_abort();
            header("Location: login");
            exit();
        }

        // Obtém as informações do usuário logado
        $userInfo = $this->userModel->getUserInfo();

        if ($userInfo) {
            // Passa as informações do usuário para a view do perfil
            include 'app/views/perfil.php';
        } else {
            // Caso algum erro ocorra, redireciona para o login
            header("Location: login");
            exit();
        }
    }
}

?>