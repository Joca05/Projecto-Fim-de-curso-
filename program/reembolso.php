<?php
session_start();
include("conexao.php");

if(!isset($_SESSION['usuario'])){
    header("Location:index.php");
    exit();
}

/* REGISTAR REEMBOLSO */
if(isset($_POST['guardar'])){

    $emprestimo_id = $_POST['emprestimo_id'];
    $valor_pago = $_POST['valor_pago'];
    $metodo_pagamento = $_POST['metodo_pagamento'];
    $observacao = $_POST['observacao'];

    $sqlInsert = "
    INSERT INTO reembolsos
    (
        emprestimo_id,
        valor_pago,
        data_pagamento,
        metodo_pagamento,
        observacao
    )
    VALUES
    (
        '$emprestimo_id',
        '$valor_pago',
        CURDATE(),
        '$metodo_pagamento',
        '$observacao'
    )
    ";

    mysqli_query($conn,$sqlInsert);

    header("Location: reembolso.php?sucesso=1");
    exit();
}

/* PESQUISA */
$pesquisa = "";

if(isset($_GET['pesquisa'])){
    $pesquisa = mysqli_real_escape_string(
        $conn,
        $_GET['pesquisa']
    );
}

/* TOTAL REEMBOLSADO */
$total = mysqli_query(
    $conn,
    "SELECT SUM(valor_pago) total FROM reembolsos"
);

$totalReembolsado = mysqli_fetch_assoc($total);

/* TOTAL PAGAMENTOS */
$pagamentos = mysqli_query(
    $conn,
    "SELECT COUNT(*) total FROM reembolsos"
);

$totalPagamentos = mysqli_fetch_assoc($pagamentos);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Consulta de Reembolsos - KixiCrédito</title>

<link rel="stylesheet" href="css/consulta.css">

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
        <li><a href="reembolso.php" class="active">💳 Reembolsos</a></li>
        <li><a href="relatorio.php">📊 Relatórios</a></li>
        <li><a href="sobre.php"> 🛈 Sobre Nós</a></li>
        <li><a href="logout.php">🚪 Sair</a></li>
    </ul>

</aside>

<main class="content">

    <!-- TÍTULO -->
    <div class="search-card">

        <h1>Gestão de Reembolsos</h1>

        <?php if(isset($_GET['sucesso'])){ ?>

        <div style="
            background:#d4edda;
            color:#155724;
            padding:12px;
            border-radius:6px;
            margin-top:15px;
        ">
            Reembolso registado com sucesso.
        </div>

        <?php } ?>

    </div>

    <!-- RESUMO -->
    <div class="table-card">

        <h2>Resumo</h2>

        <p>
            <strong>Total Reembolsado:</strong>

            <?= number_format(
                $totalReembolsado['total'] ?? 0,
                2,
                ',',
                '.'
            ); ?> Kz
        </p>

        <p>
            <strong>Pagamentos Registados:</strong>

            <?= $totalPagamentos['total']; ?>
        </p>

    </div>

    <!-- REGISTAR -->
    <div class="search-card">

        <h2>Registar Reembolso</h2>

        <form method="POST" class="search-form">

            <select
                name="emprestimo_id"
                required
            >

                <option value="">
                    Selecionar Cliente
                </option>

                <?php

                $clientes = mysqli_query($conn,"
                SELECT
                    e.id,
                    c.nome,
                    e.valor_emprestimo

                FROM emprestimos e

                INNER JOIN clientes c
                ON c.id = e.cliente_id

                ORDER BY c.nome
                ");

                while($c = mysqli_fetch_assoc($clientes)){
                ?>

                <option value="<?= $c['id']; ?>">

                    <?= $c['nome']; ?>

                    -
                    <?= number_format(
                        $c['valor_emprestimo'],
                        2,
                        ',',
                        '.'
                    ); ?> Kz

                </option>

                <?php } ?>

            </select>

            <input
                type="number"
                step="0.01"
                name="valor_pago"
                placeholder="Valor Pago"
                required
            >

            <select
                name="metodo_pagamento"
                required
            >

                <option value="">
                    Método de Pagamento
                </option>

                <option>Dinheiro</option>
                <option>Transferência</option>
                <option>Multicaixa</option>

            </select>

            <input
                type="text"
                name="observacao"
                placeholder="Observação"
            >

            <button
                type="submit"
                name="guardar"
            >
                Registar
            </button>

        </form>

    </div>

    <!-- PESQUISA -->
    <div class="search-card">

        <h2>Pesquisar Cliente</h2>

        <form method="GET" class="search-form">

            <input
                type="text"
                name="pesquisa"
                placeholder="Pesquisar cliente..."
                value="<?= $pesquisa; ?>"
            >

            <button type="submit">
                Consultar
            </button>

        </form>

    </div>

    <!-- HISTÓRICO -->
    <div class="table-card">

        <h2>Histórico de Reembolsos</h2>

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Valor Pago</th>
                    <th>Data</th>
                    <th>Método</th>
                    <th>Observação</th>
                </tr>

            </thead>

            <tbody>

            <?php

            $sql = "

            SELECT

            r.*,
            c.nome

            FROM reembolsos r

            INNER JOIN emprestimos e
            ON e.id = r.emprestimo_id

            INNER JOIN clientes c
            ON c.id = e.cliente_id

            WHERE c.nome LIKE '%$pesquisa%'

            ORDER BY r.id DESC

            ";

            $resultado = mysqli_query($conn,$sql);

            if($resultado){

                while($linha = mysqli_fetch_assoc($resultado)){
            ?>

                <tr>

                    <td><?= $linha['id']; ?></td>

                    <td><?= $linha['nome']; ?></td>

                    <td>

                        <?= number_format(
                            $linha['valor_pago'],
                            2,
                            ',',
                            '.'
                        ); ?>

                        Kz

                    </td>

                    <td>
                        <?= $linha['data_pagamento']; ?>
                    </td>

                    <td>
                        <?= $linha['metodo_pagamento']; ?>
                    </td>

                    <td>
                        <?= $linha['observacao']; ?>
                    </td>

                </tr>

            <?php
                }
            }
            ?>

            </tbody>

        </table>

    </div>

</main>

</body>
</html>