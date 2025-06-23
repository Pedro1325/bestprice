<?php

class CategoriaModel
{
    private $conn;
    private $table = 'categoria';
    public $id_categoria;
    public $nome;
    public $descricao;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function listar()
    {
        $sql = "SELECT id_categoria, nome, descricao FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $categorias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categorias[] = $row;
        }

        return $categorias;
    }

    public function adicionar($nome, $descricao)
    {
        $query = "INSERT INTO " . $this->table . " (nome, descricao) VALUES (:nome, :descricao)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function atualizar($id_categoria, $nome, $descricao)
    {
        $query = "UPDATE " . $this->table . " 
                  SET nome = :nome, 
                      descricao = :descricao 
                  WHERE id_categoria = :id_categoria";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindValue(':id_categoria', $id_categoria, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function excluir($id_categoria)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_categoria = :id_categoria";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_categoria', $id_categoria, PDO::PARAM_INT);
        return $stmt->execute();
    }
} 