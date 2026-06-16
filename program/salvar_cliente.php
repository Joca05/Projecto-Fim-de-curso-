<?php

include("conexao.php");

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$bilhete = $_POST['bilhete'];
$endereco = $_POST['endereco'];
$renda = $_POST['renda'];
$risco = $_POST['risco'];

$sql = "INSERT INTO clientes
(nome, telefone, bilhete, endereco, renda, risco)

VALUES

('$nome','$telefone','$bilhete','$endereco','$renda','$risco')";

mysqli_query($conexao, $sql);

echo "Cliente salvo com sucesso";

?>