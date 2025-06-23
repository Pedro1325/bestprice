<?php

class CadastroModel
{
    private $conn;
    public $nome;
    public $email;
    public $senha;
    public $telefone;

    public function __construct()
    {
        // A conexão com o banco de dados será feita dentro da própria classe CadastroModel
        $this->conn = (new Database())->getConnection();
    }

    // Verificar se o email já existe
    public function checkEmailExistente()
    {
        $query = "SELECT Id_User FROM usuario WHERE email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true; // Email já existe
        }
        return false; // Email não existe
    }

    // Cadastrar novo usuário
    public function salvar()
    {
        $query = "INSERT INTO usuario (nome, email, senha, telefone) VALUES (:nome, :email, :senha, :telefone)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':telefone', $this->telefone);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


}
?>