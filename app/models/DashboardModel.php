<?php


class DashboardModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getPedidosInativos()
    {
        $query = "SELECT p.id_pedido, p.id_user, p.id_estoque, p.quantidade, p.valor_total, p.status,
                         e.nome as nome_produto
                  FROM pedido p
                  JOIN estoque e ON p.id_estoque = e.id_estoque
                  WHERE p.status = 'inativo'
                  ORDER BY p.id_pedido DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalVendas()
    {
        $query = "SELECT COUNT(*) as total_vendas
                 FROM pedido
                 WHERE status = 'inativo'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_vendas'];
    }

    public function getTotalGanhos()
    {
        $query = "SELECT SUM(valor_total) as total_ganhos
                 FROM pedido
                 WHERE status = 'inativo'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_ganhos'];
    }
} 