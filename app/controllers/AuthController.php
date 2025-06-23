<?php

require_once 'config/database.php';
require_once 'app/models/UserModel.php';

class AuthController
{

    private $loginModel;

    public function __construct()
    {
        $this->loginModel = new UserModel();
    }

    public function verificaSessao()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            session_abort();
            $this->showForm();
        } else {
            header("Location: perfil");
            exit();
        }
    }

    public function showForm()
    {
        include 'app/views/login_form.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->loginModel->email = $_POST['email'];
            $this->loginModel->senha = $_POST['senha'];

            // Tenta fazer o login
            if ($this->loginModel->login()) {
                header("Location: perfil"); // Redireciona para o perfil
                exit();
            } else {
                // Se o login falhar, exibe a tela de login com uma mensagem de erro
                $error = "Email ou senha inválidos!";
                include 'app/views/login_form.php'; // Recarrega o formulário com a mensagem de erro
            }
        } else {
            // Se o método não for POST, exibe o formulário de login
            $this->verificaSessao();
        }
    }

    public function logout()
    {
        $this->loginModel->logout();
        $this->showForm();
    }
}
