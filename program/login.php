<?php

session_start();
include("conexao.php");

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios
        WHERE username='$username'
        AND password='$password'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 1){

    $dados = mysqli_fetch_assoc($result);

    $_SESSION['usuario'] = $dados['nome'];

    header("Location: dashboard.php");
    exit();

}else{

    echo "Utilizador ou senha incorretos.";

}
?>