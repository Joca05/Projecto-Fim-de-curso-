<?php
session_start();

include("conexao.php");

if(isset($_POST['guardar'])){

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $prestacao = $_POST['prestacao'];
    $endereco = $_POST['endereco'];
    $desembolso = $_POST['desembolso'];

    $sql = "INSERT INTO clientes
    (nome, telefone, prestacao, endereco, desembolso)
    VALUES
    ('$nome','$telefone','$prestacao','$endereco','$desembolso')";

    mysqli_query($conn, $sql);
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
    <title>Clientes - KixiCrédito</title>

  <link rel="stylesheet" href="css/clientes.css?=5">
<!-- MENU LATERAL -->
<aside class="sidebar">
    <div class="logo-area">
    <img src="img/logo.png" alt="Logo">
    <h2>KixiCrédito</h2>
</div>
    <ul>
        <li><a href="dashboard.php">🏠 Dashboard</a></li>
        <li><a href="clientes.php" class="active">👥 Clientes</a></li>
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

    <!-- FORMULÁRIO -->
    <div class="card">

        <h1>Cadastro de Clientes</h1>

        <form method="POST">

            <input type="text"
                   name="nome"
                   placeholder="Nome do Cliente"
                   required><p></p>
                   <p>

                   </p>
            <input type="text"
                   name="telefone"
                   placeholder="Número de Telefone"
                   required><p></p>

            <input type="number"
                   step="0.01"
                   name="prestacao"
                   placeholder="Prestação"
                   required><p></p>

            <input type="text"
                   name="endereco"
                   placeholder="Endereço"
                   required><p></p>

            <input type="number"
                   step="0.01"
                   name="desembolso"
                   placeholder="Desembolso"
                   required><p></p>

            <button type="submit" name="guardar">
                Guardar Cliente
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

    <!-- TABELA -->
    <div class="table-card">

        <h2>Clientes Registados</h2>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Prestação</th>
                    <th>Endereço</th>
                    <th>Desembolso</th>
                </tr>
            </thead>

            <tbody>

            <?php

            $resultado = mysqli_query(
                $conn,
                "SELECT * FROM clientes ORDER BY id DESC"
            );

            if($resultado){

                while($linha = mysqli_fetch_assoc($resultado)){
            ?>

                <tr>
                    <td><?= $linha['id']; ?></td>
                    <td><?= $linha['nome']; ?></td>
                    <td><?= $linha['telefone']; ?></td>
                    <td><?= number_format($linha['prestacao'],2,',','.'); ?> Kz</td>
                    <td><?= $linha['endereco']; ?></td>
                    <td><?= number_format($linha['desembolso'],2,',','.'); ?> Kz</td>
                </tr>

            <?php
                }
            }
            ?>

            </tbody>

        </table>

    </div>

</main>