<?php
class EnderecoModel
{
    private $conn;

    public $cep;
    public $rua;
    public $bairro;
    public $cidade;
    public $uf;
    public $numero;
    public $complemento;
    public $id_user;
    
    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function salvar()
    {
        session_start();
        $this->id_user = $_SESSION['user_id'] ?? null;

        if (!$this->id_user) {
            return false;
        }

        $query = "INSERT INTO endereco (CEP, Rua, Bairro, Cidade, UF, Numero, Complemento, Id_User) 
                  VALUES (:CEP, :Rua, :Bairro, :Cidade, :UF, :Numero, :Complemento, :Id_User)";
                  
       $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':CEP',        $this->cep);
        $stmt->bindParam(':Rua',        $this->rua);
        $stmt->bindParam(':Bairro',     $this->bairro);
        $stmt->bindParam(':Cidade',     $this->cidade);
        $stmt->bindParam(':UF',         $this->uf);
        $stmt->bindParam(':Numero',     $this->numero);
        $stmt->bindParam(':Complemento', $this->complemento);
        $stmt->bindParam(':Id_User',    $this->id_user);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function excluir($id_endereco)
    {
        session_start();
        $id_user = $_SESSION['user_id'] ?? null;

        if (!$id_user) {
            return false;
        }

        // Verifica se o endereço pertence ao usuário antes de excluir
        $query = "DELETE FROM endereco WHERE id_endereco = :id_endereco AND id_user = :id_user";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_endereco', $id_endereco);
        $stmt->bindParam(':id_user', $id_user);

        return $stmt->execute();
    }

}
