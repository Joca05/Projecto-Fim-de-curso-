<!-- credito.php -->
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
<!-- LOGO -->
       
    <title>Gestão de Créditos</title>

    <link rel="stylesheet" href="css/inicio.css?=5">
</head>

<body>
 
    <!-- MENU -->
    <header class="menu">

        <div class="logo">
            <h2>KixiCrédito</h2>
        </div>

        <nav>
        <li><a href="dashboard.php">🏠 Inicio</a></li>
        <li><a href="clientes.php">👥 Clientes</a></li>
        <li><a href="credito.php" class="active">📄 Empréstimos</a></li>
        <li><a href="desembolso.php">💰 Desembolsos</a></li>
        <li><a href="reembolso.php">💳 Reembolsos</a></li>
        <li><a href="logout.php">🚪 Sair</a></li>
        </nav>

    </header>

    <!-- HERO -->
    <section class="hero">

        <div class="overlay"></div>

        <div class="hero-conteudo">
            <h1>Gestão de Empréstimos e Desembolsos</h1>

            <p>
                Plataforma profissional para consulta e gerenciamento
                de créditos financeiros.
            </p>

            <li><a href="credito.php" class="active"><button>Consultar Créditos</button></a></li>
        </div>

    </section>

    <!-- ESTATÍSTICAS -->
    <section class="estatisticas">

        <div class="box">
            <h2>250+</h2>
            <p>Clientes Ativos</p>
        </div>

        <div class="box">
            <h2>120M Kz</h2>
            <p>Desembolsados</p>
        </div>

        <div class="box">
            <h2>98%</h2>
            <p>Taxa de Aprovação</p>
        </div>

    </section>

    <!-- TIPOS DE CRÉDITO -->
    <section class="titulo-section">
        <h1>Tipos de Crédito</h1>
        <p>Selecione o produto ideal para o cliente</p>
    </section>

    <section class="creditos">

        <!-- KIXI FÁCIL -->
        <div class="card">

            <div class="icone">💳</div>

            <h2>Kixi Fácil</h2>

            <p>
                Crédito rápido e simplificado para despesas pessoais,
                pequenos investimentos e necessidades imediatas.
            </p>

            <div class="info">
                <span>Prazo: 3 - 12 meses</span>
                <span>Taxa reduzida</span>
            </div>

            <button>Consultar</button>

        </div>

        <!-- KIXI NEGÓCIO -->
        <div class="card destaque">

            <div class="tag">Mais Procurado</div>

            <div class="icone">🏪</div>

            <h2>Kixi Negócio</h2>

            <p>
                Solução financeira para comerciantes e empreendedores
                expandirem os seus negócios com segurança.
            </p>

            <div class="info">
                <span>Prazo: 6 - 24 meses</span>
                <span>Maior limite</span>
            </div>

            <button>Consultar</button>

        </div>

        <!-- KIXI AGRONEGÓCIO -->
        <div class="card">

            <div class="icone">🌾</div>

            <h2>Kixi Agronegócio</h2>

            <p>
                Crédito especializado para agricultores, produção rural
                e desenvolvimento do setor agrícola.
            </p>

            <div class="info">
                <span>Prazo: até 36 meses</span>
                <span>Apoio agrícola</span>
            </div>

            <button>Consultar</button>

        </div>

    </section>

    <!-- TABELA -->
    <section class="tabela-section">

        <h1>Últimos Desembolsos</h1>

       <div class="table-card">


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