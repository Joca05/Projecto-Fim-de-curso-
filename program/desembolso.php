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
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Consulta de Desembolsos - KixiCrédito</title>

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
        <li><a href="desembolso.php" class="active">💰 Desembolsos</a></li>
        <li><a href="reembolso.php">💳 Reembolsos</a></li>
        <li><a href="relatorios.php">📊 Relatórios</a></li>
        <li><a href="sobre.php"> 🛈 Sobre Nós</a></li>
        <li><a href="logout.php">🚪 Sair</a></li>
    </ul>

</aside>

<!-- CONTEÚDO -->
<main class="content">

    <!-- PESQUISA -->
    <div class="search-card">

        <h1>Consulta de Desembolsos</h1>

        <form method="GET" class="search-form">

            <input
                type="text"
                name="pesquisa"
                placeholder="Pesquisar cliente..."
                value="<?php echo $pesquisa; ?>"
            >

            <button type="submit">
                Consultar
            </button>

        </form>

    </div>

    <!-- TABELA -->
    <div class="table-card">

        <h2>Histórico de Desembolsos</h2>

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Juros</th>
                    <th>Prazo</th>
                    <th>Prestação</th>
                    <th>Data Desembolso</th>
                    <th>Vencimento</th>
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

            if($resultado){

                while($linha = mysqli_fetch_assoc($resultado)){
            ?>

                <tr>

                    <td><?= $linha['id']; ?></td>

                    <td><?= $linha['nome']; ?></td>

                    <td>
                        <?= number_format($linha['valor_emprestimo'],2,',','.'); ?>
                        Kz
                    </td>

                    <td>
                        <?= $linha['taxa_juros']; ?>%
                    </td>

                    <td>
                        <?= $linha['prazo_meses']; ?> meses
                    </td>

                    <td>
                        <?= number_format($linha['prestacao_mensal'],2,',','.'); ?>
                        Kz
                    </td>

                    <td>
                        <?= $linha['data_desembolso']; ?>
                    </td>

                    <td>
                        <?= $linha['data_vencimento']; ?>
                    </td>

                    <td>
                        <?= $linha['status']; ?>
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