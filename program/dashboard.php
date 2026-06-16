<?php
session_start();
include("conexao.php");

if(!isset($_SESSION['usuario'])){
    header("Location:index.php");
    exit();
}

$pesquisa = "";

if(isset($_GET['pesquisa'])){
    $pesquisa = mysqli_real_escape_string(
        $conn,
        $_GET['pesquisa']
    );
}

/* TOTAL CLIENTES */
$resClientes = mysqli_query(
    $conn,
    "SELECT COUNT(*) total FROM clientes"
);

$totalClientes = mysqli_fetch_assoc($resClientes);

/* TOTAL EMPRÉSTIMOS */
$resEmprestimos = mysqli_query(
    $conn,
    "SELECT SUM(valor_emprestimo) total
     FROM emprestimos"
);

$totalEmprestimos = mysqli_fetch_assoc($resEmprestimos);

/* TOTAL REEMBOLSOS */
$resReembolsos = mysqli_query(
    $conn,
    "SELECT SUM(valor_pago) total
     FROM reembolsos"
);

$totalReembolsos = mysqli_fetch_assoc($resReembolsos);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard - KixiCrédito</title>

<link rel="stylesheet" href="css/consulta.css?=5">

</head>
<body>

<!-- MENU -->
<aside class="sidebar">

    
    <div class="logo-area">
    <img src="img/logo.png" alt="Logo">
    <h2>KixiCrédito</h2>
</div>

    <ul>
        <li><a href="dashboard.php" class="active">🏠 Dashboard</a></li>
        <li><a href="clientes.php">👥 Clientes</a></li>
        <li><a href="credito.php">📄 Empréstimos</a></li>
        <li><a href="desembolso.php">💰 Desembolsos</a></li>
        <li><a href="reembolso.php">💳 Reembolsos</a></li>
        <li><a href="relatorio.php">📊 Relatórios</a></li>
        <li><a href="sobre.php"> 🛈 Sobre Nós</a></li>
        <li><a href="logout.php">🚪 Sair</a></li>
    </ul>

</aside>

<!-- CONTEÚDO -->
<main class="content">

    <!-- TÍTULO -->
    <div class="search-card">

        <h1>Dashboard KixiCrédito</h1>

        <form method="GET" class="search-form">

            <input
                type="text"
                name="pesquisa"
                placeholder="Pesquisar cliente..."
                value="<?= $pesquisa; ?>"
            >

            <button type="submit">
                Pesquisar
            </button>

        </form>

    </div>

    <!-- CARDS -->
    <div class="table-card">

        <h2>Resumo do Sistema</h2>

        <div style="
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:20px;
        margin-top:20px;">

            <div style="
            background:#0a7d33;
            color:white;
            padding:25px;
            border-radius:10px;
            text-align:center;">

                <h3>Total Clientes</h3>

                <h1>
                <?= $totalClientes['total']; ?>
                </h1>

            </div>

            <div style="
            background:#0066cc;
            color:white;
            padding:25px;
            border-radius:10px;
            text-align:center;">

                <h3>Total Empréstimos</h3>

                <h1>

                <?= number_format(
                    $totalEmprestimos['total'] ?? 0,
                    2,
                    ',',
                    '.'
                ); ?>

                Kz

                </h1>

            </div>

            <div style="
            background:#ff9800;
            color:white;
            padding:25px;
            border-radius:10px;
            text-align:center;">

                <h3>Total Reembolsado</h3>

                <h1>

                <?= number_format(
                    $totalReembolsos['total'] ?? 0,
                    2,
                    ',',
                    '.'
                ); ?>

                Kz

                </h1>

            </div>

        </div>

    </div>

    <!-- CLIENTES -->
    <div class="table-card">

        <h2>Últimos Clientes</h2>

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Prestação</th>
                    <th>Desembolso</th>
                </tr>

            </thead>

            <tbody>

            <?php

            $sql = "
            SELECT *
            FROM clientes
            WHERE nome LIKE '%$pesquisa%'
            ORDER BY id DESC
            LIMIT 10
            ";

            $resultado = mysqli_query($conn,$sql);

            while($linha = mysqli_fetch_assoc($resultado)){
            ?>

                <tr>

                    <td><?= $linha['id']; ?></td>

                    <td><?= $linha['nome']; ?></td>

                    <td><?= $linha['telefone']; ?></td>

                    <td>

                        <?= number_format(
                            $linha['prestacao'],
                            2,
                            ',',
                            '.'
                        ); ?>

                        Kz

                    </td>

                    <td>

                        <?= number_format(
                            $linha['desembolso'],
                            2,
                            ',',
                            '.'
                        ); ?>

                        Kz

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</main>

</body>
</html>