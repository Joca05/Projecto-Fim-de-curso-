<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "kixicredito";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>