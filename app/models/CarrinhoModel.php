<?php
class CarrinhoModel
{
    private $conn;
    private $table = 'pedido';

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function adicionar($id_user, $id_estoque, $quantidade)
    {
        // Primeiro, busca o valor unitário do estoque
        $sql_estoque = "SELECT valor_un, quantidade as quantidade_estoque FROM estoque WHERE id_estoque = :id_estoque";
        $stmt_estoque = $this->conn->prepare($sql_estoque);
        $stmt_estoque->bindValue(':id_estoque', $id_estoque, PDO::PARAM_INT);
        $stmt_estoque->execute();
        $estoque = $stmt_estoque->fetch(PDO::FETCH_ASSOC);

        // Verifica se há estoque suficiente
        if ($quantidade > $estoque['quantidade_estoque']) {
            return false;
        }

        // Calcula o valor total
        $valor_total = $estoque['valor_un'] * $quantidade;

        $query = "INSERT INTO " . $this->table . " (id_user, id_estoque, quantidade, valor_total, status) 
                  VALUES (:id_user, :id_estoque, :quantidade, :valor_total, 'ativo')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindValue(':id_estoque', $id_estoque, PDO::PARAM_INT);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':valor_total', $valor_total, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function listarCarrinho($id_user)
    {
        $sql = "SELECT p.id_pedido, p.quantidade, p.valor_total, 
                       e.nome, e.valor_un, e.foto, e.quantidade as quantidade_estoque,
                       e.descricao
                FROM pedido p 
                JOIN estoque e ON p.id_estoque = e.id_estoque 
                WHERE p.id_user = :id_user AND p.status = 'ativo'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();

        $itens = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $itens[] = $row;
        }

        return $itens;
    }

    public function atualizarQuantidade($id_pedido, $quantidade)
    {
        // Primeiro, busca o valor unitário e quantidade em estoque
        $sql = "SELECT e.valor_un, e.quantidade as quantidade_estoque 
                FROM pedido p 
                JOIN estoque e ON p.id_estoque = e.id_estoque 
                WHERE p.id_pedido = :id_pedido";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se há estoque suficiente
        if ($quantidade > $dados['quantidade_estoque']) {
            return false;
        }

        // Calcula o novo valor total
        $valor_total = $dados['valor_un'] * $quantidade;

        $query = "UPDATE " . $this->table . " 
                  SET quantidade = :quantidade,
                      valor_total = :valor_total
                  WHERE id_pedido = :id_pedido";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':valor_total', $valor_total, PDO::PARAM_STR);
        $stmt->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function remover($id_pedido)
    {
        // Remove o pedido da tabela
        $query = "DELETE FROM " . $this->table . " WHERE id_pedido = :id_pedido";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function finalizarPedidos($id_user)
    {
        // Muda o status dos pedidos ativos para inativo
        $query = "UPDATE " . $this->table . " 
                  SET status = 'inativo' 
                  WHERE id_user = :id_user AND status = 'ativo'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
