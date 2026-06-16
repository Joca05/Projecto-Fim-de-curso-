<?php
session_start();
include("conexao.php");
$pesquisa = "";

if(isset($_GET['pesquisa'])){
    $pesquisa = mysqli_real_escape_string($conn, $_GET['pesquisa']);
}
if(isset($_POST['guardar'])){

    $cliente_id = $_POST['cliente_id'];
    $valor = $_POST['valor'];
    $juros = $_POST['juros'];
    $prazo = $_POST['prazo'];

    $valor_total = $valor + ($valor * $juros / 100);
    $prestacao = $valor_total / $prazo;

    $sql = "INSERT INTO emprestimos
    (
        cliente_id,
        valor_emprestimo,
        taxa_juros,
        prazo_meses,
        valor_total,
        prestacao_mensal,
        data_desembolso,
        data_vencimento,
        status
    )
    VALUES
    (
        '$cliente_id',
        '$valor',
        '$juros',
        '$prazo',
        '$valor_total',
        '$prestacao',
        CURDATE(),
        DATE_ADD(CURDATE(), INTERVAL $prazo MONTH),
        'Ativo'
    )";

    mysqli_query($conn,$sql);

    /* EVITA DUPLICAÇÃO */
    header("Location: credito.php?sucesso=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Empréstimos - KixiCrédito</title>

<link rel="stylesheet" href="css/credito.css">

</head>
<body>

<aside class="sidebar">

    <div class="logo-area">
    <img src="img/logo.png" alt="Logo">
    <h2>KixiCrédito</h2>
</div>

    <ul>
        <li><a href="dashboard.php">🏠 Dashboard</a></li>
        <li><a href="clientes.php">👥 Clientes</a></li>
        <li><a href="credito.php" class="active">📄 Empréstimos</a></li>
        <li><a href="desembolso.php">💰 Desembolsos</a></li>
        <li><a href="reembolso.php">💳 Reembolsos</a></li>
        <li><a href="relatorio.php">📊 Relatórios</a></li>
        <li><a href="sobre.php"> 🛈 Sobre Nós</a></li>
        <li><a href="logout.php">🚪 Sair</a></li>
    </ul>

</aside>

<main class="content">

    <div class="card">

        <h1>Registar Empréstimo</h1>

        <?php if(isset($_GET['sucesso'])){ ?>
            <div style="
                background:#d4edda;
                color:#155724;
                padding:10px;
                border-radius:5px;
                margin-bottom:15px;
            ">
                Empréstimo registado com sucesso!
            </div>
        <?php } ?>

        <form method="POST">

            <select name="cliente_id" required>

                <option value="">Selecionar Cliente</option>

                <?php
                $clientes = mysqli_query(
                    $conn,
                    "SELECT * FROM clientes ORDER BY nome"
                );

                while($c = mysqli_fetch_assoc($clientes)){
                ?>

                <option value="<?= $c['id']; ?>">
                    <?= $c['nome']; ?>
                </option>

                <?php } ?>

            </select>

            <input
                type="number"
                step="0.01"
                name="valor"
                placeholder="Valor do Empréstimo"
                required
            >

            <input
                type="number"
                step="0.01"
                name="juros"
                placeholder="Taxa de Juros (%)"
                required
            >

            <input
                type="number"
                name="prazo"
                placeholder="Prazo em Meses"
                required
            >

            <button type="submit" name="guardar">
                Guardar Empréstimo
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

    <div class="table-card">

        <h2>Empréstimos Registados</h2>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Juros</th>
                    <th>Prazo</th>
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
WHERE c.nome LIKE '%$pesquisa%'
ORDER BY e.id DESC
";

            $resultado = mysqli_query($conn,$sql);

            while($linha = mysqli_fetch_assoc($resultado)){
            ?>

                <tr>
                    <td><?= $linha['id']; ?></td>
                    <td><?= $linha['nome']; ?></td>
                    <td><?= number_format($linha['valor_emprestimo'],2,',','.'); ?> Kz</td>
                    <td><?= $linha['taxa_juros']; ?>%</td>
                    <td><?= $linha['prazo_meses']; ?></td>
                    <td><?= number_format($linha['prestacao_mensal'],2,',','.'); ?> Kz</td>
                    <td><?= $linha['status']; ?></td>
                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</main>

</body>
</html>