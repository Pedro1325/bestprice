<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--link bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Admin Dashboard - BestPrice</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>

<body>

    <!-- Inclui o layout da área administrativa -->
    <?php
    $admin = file_get_contents('app/views/admin.php');
    echo $admin;
    ?>

    <!-- Cards de Estatísticas -->
    <div class="db-cardBox">
        <div class="db-card">
            <div>
                <div class="db-numbers">1,504</div>
                <div class="db-cardName">Daily Views</div>
            </div>

            <div class="db-iconBx">
                <ion-icon name="eye-outline"></ion-icon>
            </div>
        </div>

        <div class="db-card">
            <div>
                <div class="db-numbers"><?php echo $vendas; ?></div>
                <div class="db-cardName">Total de Vendas</div>
            </div>

            <div class="db-iconBx">
                <ion-icon name="cart-outline"></ion-icon>
            </div>
        </div>

        <div class="db-card">
            <div>
                <div class="db-numbers">R$ <?php echo number_format($ganhos, 2, ',', '.'); ?></div>
                <div class="db-cardName">Ganhos Totais</div>
            </div>
            <div class="db-iconBx">
                <ion-icon name="cash-outline"></ion-icon>
            </div>
        </div>
    </div>

    <!-- Lista de Pedidos Recentes -->
    <div class="db-details">
        <div class="db-recentOrders">
            <div class="db-cardHeader">
                <h2>Pedidos Recentes</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <td>Produto</td>
                        <td>Quantidade</td>
                        <td>Valor Total</td>
                        <td>Status</td>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['nome_produto']); ?></td>
                            <td><?php echo $pedido['quantidade']; ?></td>
                            <td>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></td>
                            <td><span class="db-status inativo">Inativo</span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>