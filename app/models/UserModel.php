<?php
class UserModel
{
    private $conn;
    private $table_name = "usuario";
    public $email;
    public $senha;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function login()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        $query = "SELECT id_user, email, senha FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($this->senha, $row['senha'])) {
                $_SESSION['user_id'] = $row['id_user'];
                return true;
            }
        }

        return false;
    }

    public function isAdmin($user_id)
    {
        // Faz a consulta no banco de dados para buscar o 'role' do usuário
        $query = "SELECT role FROM " . $this->table_name . " WHERE id_user = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    
        // Se o usuário for encontrado, verifica o role
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Verifica se o role é 'admin'
            if ($row['role'] === 'admin') {
                return true; // O usuário tem role de admin
            }
        }
    
        return false; // O usuário não é admin ou não foi encontrado
    }

    public function buscaEnderecos()
    {
        // Verifica se o id_user está definido na sessão
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        // Obtém o id_user da sessão
        $id_user = $_SESSION['user_id'];

        // Query para buscar todas as colunas da tabela endereco usando o id_user
        $query = "SELECT id_endereco, Rua, Bairro, Cidade, UF, Numero, Complemento, CEP FROM endereco WHERE id_user = :id_user";

        // Preparando a query
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

        // Executando a consulta
        $stmt->execute();

        // Verifica se o resultado da consulta existe
        if ($stmt->rowCount() > 0) {
            // Obtém todos os resultados
            $enderecos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Array para armazenar os endereços formatados
            $enderecosCompletos = [];

            foreach ($enderecos as $endereco) {
                $enderecosCompletos[] = [
                    'id_endereco' => $endereco['id_endereco'],
                    'cep' => $endereco['CEP'],
                    'endereco_formatado' => $endereco['Rua'] . ', ' .
                        $endereco['Bairro'] . ', ' .
                        'N°' . $endereco['Numero'] . ', ' .
                        $endereco['Cidade'] . ' - ' .
                        $endereco['UF'] . ', ' .
                        (!empty($endereco['Complemento']) ? 'Complemento: ' . $endereco['Complemento'] : '')
                ];
            }

            return $enderecosCompletos;
        }

        // Se não encontrar nenhum endereço, retorna null
        return null;
    }

    public function getUserInfo()
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $query = "SELECT nome, email, telefone FROM " . $this->table_name . " WHERE id_user = :id_user LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $_SESSION['user_id']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $endereco = [];
            $endereco = $this->buscaEnderecos();

            return [
                'nome' => $user['nome'],
                'email' => $user['email'],
                'telefone' => $user['telefone'],
                'endereco' => $endereco
            ];
        }

        return null;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
}
