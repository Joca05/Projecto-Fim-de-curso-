<?php

include("conexao.php");

if(isset($_POST['registrar'])){

    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $verifica = mysqli_query($conn,
        "SELECT * FROM usuarios WHERE username='$username'");

    if(mysqli_num_rows($verifica) > 0){

        echo "Este nome de utilizador já existe.";

    }else{

        $sql = "INSERT INTO usuarios(nome, username, password)
                VALUES('$nome','$username','$password')";

        if(mysqli_query($conn, $sql)){

            echo "Utilizador registado com sucesso!";

        }else{

            echo "Erro ao registrar.";
        }
    }
}
?>