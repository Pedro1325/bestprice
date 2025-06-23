<?php
class EstoqueModel
{
    private $conn;

    private $table = 'estoque';

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function adicionar($nome, $foto, $quantidade, $valor_un, $descricao)
    {
        $query = "INSERT INTO " . $this->table . " (Nome, Foto, Quantidade, Valor_UN, Descricao) 
                  VALUES (:nome, :foto, :quantidade, :valor_un, :descricao)";

        $foto_blob = ($foto) ? file_get_contents($foto) : NULL;

        // Formata o valor unitário para usar ponto como separador decimal
        $valor_un = str_replace(',', '.', $valor_un);

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':foto', $foto_blob, PDO::PARAM_LOB);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':valor_un', $valor_un, PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $descricao);

        return $stmt->execute();
    }

    public function listarEstoque(): array
    {
        $sql = "SELECT id_estoque, nome, foto, descricao, quantidade, valor_un FROM estoque";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $produtos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $produtos[] = $row;
        }

        return $produtos;
    }

    public function buscar($id_estoque)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE Id_Estoque = :id_estoque";
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':id_estoque', $id_estoque, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id_estoque, $nome, $foto, $quantidade, $valor_un, $descricao)
    {
        if ($foto) {
            $foto_blob = file_get_contents($foto);
            $query = "UPDATE " . $this->table . " 
                      SET Nome = :nome, 
                          Foto = :foto, 
                          Quantidade = :quantidade, 
                          Valor_UN = :valor_un, 
                          Descricao = :descricao 
                      WHERE Id_Estoque = :id_estoque";

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(':foto', $foto_blob, PDO::PARAM_LOB);
        } else {
            $query = "UPDATE " . $this->table . " 
                      SET Nome = :nome, 
                          Quantidade = :quantidade, 
                          Valor_UN = :valor_un, 
                          Descricao = :descricao 
                      WHERE Id_Estoque = :id_estoque";

            $stmt = $this->conn->prepare($query);
        }

        // Formata o valor unitário para usar ponto como separador decimal
        $valor_un = str_replace(',', '.', $valor_un);

        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':valor_un', $valor_un, PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindValue(':id_estoque', $id_estoque, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function desvincular($id_estoque)
    {

        $query = "UPDATE {$this->table} SET Id_Produto = NULL WHERE Id_Estoque = :id_estoque";
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':id_estoque', $id_estoque, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function vincular($id_produto, $id_estoques)
    {
        $placeholders = array_map(function($index) {
            return ":id_estoque{$index}";
        }, array_keys($id_estoques));

        $placeholdersString = implode(', ', $placeholders);

        $query = "UPDATE {$this->table} SET Id_Produto = :id_produto WHERE Id_Estoque IN ({$placeholdersString})";
        $stmt = $this->conn->prepare($query);

        foreach ($id_estoques as $index => $id_estoque) {
            $stmt->bindValue(":id_estoque{$index}", $id_estoque, PDO::PARAM_INT);
        }
        $stmt->bindValue(':id_produto', $id_produto, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function excluir($id_estoque)
    {
        $query = "DELETE FROM " . $this->table . " WHERE Id_Estoque = :id_estoque";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_estoque', $id_estoque, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
