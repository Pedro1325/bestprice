<?php

class ProdutoModel
{
    private $conn;
    public $nome;
    public $id_categoria;
    public $descricao;
    public $fotoBinario;
    public $produtosSelecionados;
    public $id_produto;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function adicionarProduto($nome, $id_categoria, $descricao, $fotoBinario)
    {
        if (empty($nome) || empty($id_categoria)) {
            die("Todos os campos precisam ser preenchidos.");
        }

        $sql = "INSERT INTO produto (Nome, Id_Categoria, Descricao, Foto) VALUES (:Nome, :Id_Categoria, :Descricao, :Foto)";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':Nome' => $nome,
            ':Id_Categoria' => $id_categoria,
            ':Descricao' => $descricao,
            ':Foto' => $fotoBinario
        ]);

        $id_produto = $this->conn->lastInsertId();
        $this->atualizarEstoque($id_produto);
    }

    public function editarProduto($id_produto, $nome, $id_categoria, $descricao, $foto)
    {
        if (empty($id_produto) || empty($nome) || empty($id_categoria)) {
            die("Todos os campos precisam ser preenchidos.");
        }
        if ($foto) {
            $foto_blob = file_get_contents($foto);

            $query = "UPDATE produto
                      SET Nome = :nome, 
                          Foto = :foto,
                          Descricao = :descricao,
                          Id_Categoria = :id_categoria
                      WHERE Id_Produto = :id_produto";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':foto', $foto_blob, PDO::PARAM_LOB);
        } else {
            $query = "UPDATE produto
                      SET Nome = :nome,
                          Descricao = :descricao,
                          Id_Categoria = :id_categoria
                      WHERE Id_Produto = :id_produto";

            $stmt = $this->conn->prepare($query);
        }

        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindValue(':id_categoria', $id_categoria, PDO::PARAM_STR);
        $stmt->bindValue(':id_produto', $id_produto, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function listarProdutosComValor()
    {

        $temBusca = isset($_GET['buscar']) && trim($_GET['buscar']) !== '';
        $busca = $temBusca ? trim($_GET['buscar']) : '';


        $temCategoria = isset($_GET['categoria']) && trim($_GET['categoria']) !== '';
        $categoria = $temCategoria ? (int)$_GET['categoria'] : null;

        $sql = "
            SELECT p.id_produto, p.nome, p.descricao, p.foto, e.valor_un
            FROM produto p
            LEFT JOIN (SELECT id_produto, MIN(valor_un) AS valor_un
                            FROM estoque
                            GROUP BY id_produto
                        ) e ON p.id_produto = e.id_produto ";

        $stmt = $this->conn->prepare($sql);

        $whereClauses = [];

        if ($temBusca) {
            $whereClauses[] = "p.nome LIKE :nome";
        }

        if ($temCategoria) {
            $whereClauses[] = "p.id_categoria = :categoria";
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $stmt = $this->conn->prepare($sql);

        if ($temBusca) {
            $stmt->bindValue(':nome', '%' . $busca . '%', PDO::PARAM_STR);
        }

        if ($temCategoria) {
            $stmt->bindValue(':categoria', $categoria, PDO::PARAM_INT);
        }

        $stmt->execute();

        $produtos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $produtos[] = $row;
        }

        return $produtos;
    }

    public function listarProdutos()
    {
        $sql = "SELECT p.id_produto, p.nome, p.foto, p.descricao, p.id_categoria, c.nome AS categoria
            FROM produto p
            LEFT JOIN categoria c ON p.id_categoria = c.id_categoria";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $produtos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $produtos[] = $row;
        }

        return $produtos;
    }

    public function buscarProdutoPorId($id)
    {
        $sql = "SELECT nome, descricao, foto FROM produto WHERE id_Produto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $produto;
    }

    public function buscarEstoquePorProduto($id)
    {
        $sql = "SELECT id_estoque, nome, foto, quantidade, valor_un, descricao FROM estoque WHERE id_produto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $estoques = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $estoques[] = $row;
        }

        return $estoques;
    }

    public function listarEstoque()
    {
        $sql = "SELECT id_estoque, id_produto, nome, foto, descricao, quantidade, valor_un FROM estoque";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $estoques = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $estoques[] = $row;
        }

        return $estoques;
    }

    public function listarCategoria()
    {
        $sql = "SELECT id_categoria, nome, descricao FROM categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $categorias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categorias[] = $row;
        }

        return $categorias;
    }

    public function atualizarEstoque($id_recebido)
    {
        $id_produto = $id_recebido;

        $produtosSelecionados = $_POST['produtos'];

        $produtosSelecionados = array_map('intval', $produtosSelecionados);
        $placeholders = str_repeat('?,', count($produtosSelecionados) - 1) . '?';

        $sqlUpdate = "UPDATE estoque SET Id_produto = ? WHERE Id_Estoque IN ($placeholders)";

        $stmtUpdate = $this->conn->prepare($sqlUpdate);
        $stmtUpdate->bindValue(1, $id_produto, PDO::PARAM_INT);

        $params = array_merge([$id_produto], $produtosSelecionados);
        $stmtUpdate->execute($params);
    }

    public function excluir($id_produto)
    {
        $query = "DELETE FROM produto WHERE Id_produto = :id_produto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_produto', $id_produto, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
