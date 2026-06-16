<?php
session_start();
include("conexao.php");

if(!isset($_SESSION['usuario'])){
    header("Location:index.php");
    exit();
}

/* TOTAL CLIENTES */
$clientes = mysqli_query(
    $conn,
    "SELECT COUNT(*) total FROM clientes"
);
$totalClientes = mysqli_fetch_assoc($clientes);

/* TOTAL EMPRÉSTIMOS */
$emprestimos = mysqli_query(
    $conn,
    "SELECT SUM(valor_emprestimo) total
     FROM emprestimos"
);
$totalEmprestimos = mysqli_fetch_assoc($emprestimos);

/* TOTAL REEMBOLSOS */
$reembolsos = mysqli_query(
    $conn,
    "SELECT SUM(valor_pago) total
     FROM reembolsos"
);
$totalReembolsos = mysqli_fetch_assoc($reembolsos);

/* EMPRÉSTIMOS ATIVOS */
$ativos = mysqli_query(
    $conn,
    "SELECT COUNT(*) total
     FROM emprestimos
     WHERE status='Ativo'"
);
$totalAtivos = mysqli_fetch_assoc($ativos);

/* EMPRÉSTIMOS PAGOS */
$pagos = mysqli_query(
    $conn,
    "SELECT COUNT(*) total
     FROM emprestimos
     WHERE status='Pago'"
);
$totalPagos = mysqli_fetch_assoc($pagos);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Relatórios - KixiCrédito</title>

<link rel="stylesheet" href="css/relatorio.css">

</head>
<body>

<!-- MENU -->
<aside class="sidebar">

    <div class="logo-area">
    <img src="img/logo.png" alt="Logo">
    <h2>KixiCrédito</h2>
</div>

    <ul>
        <li><a href="dashboard.php">🏠 Dashboard</a></li>
        <li><a href="clientes.php">👥 Clientes</a></li>
        <li><a href="credito.php">📄 Empréstimos</a></li>
        <li><a href="desembolso.php">💰 Desembolsos</a></li>
        <li><a href="reembolso.php">💳 Reembolsos</a></li>
        <li><a href="relatorio.php" class="active">📊 Relatórios</a></li>
        <li><a href="sobre.php"> 🛈 Sobre Nós</a></li>
        <li><a href="logout.php">🚪 Sair</a></li>
    </ul>

</aside>

<main class="content">

    <div class="search-card">
        <h1>Relatórios do Sistema</h1>
        <p>
            Resumo geral das operações do KixiCrédito.
        </p>
    </div>

    <div class="table-card">

        <h2>Indicadores Gerais</h2>

        <table>

            <tr>
                <td><strong>Total de Clientes</strong></td>
                <td><?= $totalClientes['total']; ?></td>
            </tr>

            <tr>
                <td><strong>Total de Empréstimos</strong></td>
                <td>
                    <?= number_format(
                        $totalEmprestimos['total'] ?? 0,
                        2,
                        ',',
                        '.'
                    ); ?> Kz
                </td>
            </tr>

            <tr>
                <td><strong>Total Reembolsado</strong></td>
                <td>
                    <?= number_format(
                        $totalReembolsos['total'] ?? 0,
                        2,
                        ',',
                        '.'
                    ); ?> Kz
                </td>
            </tr>

            <tr>
                <td><strong>Empréstimos Ativos</strong></td>
                <td><?= $totalAtivos['total']; ?></td>
            </tr>

            <tr>
                <td><strong>Empréstimos Pagos</strong></td>
                <td><?= $totalPagos['total']; ?></td>
            </tr>

        </table>

    </div>

    <div class="table-card">

        <h2>Últimos Empréstimos</h2>

        <table>

            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Prestação</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

            <?php

            $sql = "
            SELECT
            e.*,
            c.nome

            FROM emprestimos e

            INNER JOIN clientes c
            ON c.id = e.cliente_id

            ORDER BY e.id DESC
            LIMIT 10
            ";

            $resultado = mysqli_query($conn,$sql);

            while($linha = mysqli_fetch_assoc($resultado)){
            ?>

                <tr>

                    <td><?= $linha['nome']; ?></td>

                    <td>
                        <?= number_format(
                            $linha['valor_emprestimo'],
                            2,
                            ',',
                            '.'
                        ); ?> Kz
                    </td>

                    <td>
                        <?= number_format(
                            $linha['prestacao_mensal'],
                            2,
                            ',',
                            '.'
                        ); ?> Kz
                    </td>

                    <td>
                        <?= $linha['status']; ?>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</main>

</body>
</html>