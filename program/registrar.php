<?php 
session_start(); 
if(!isset($_SESSION['usuario']))
{ header("Location: index.php"); 
exit(); 
} 
?> 
<!DOCTYPE html> <html lang="pt"> 
<head>
 <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>Registrar Utilizador - KixiCrédito</title>
<link rel="stylesheet" href="css/consulta.css?=5">
</head> 
<body> 
    <div class="sidebar">
         <h2>KixiCrédito</h2> 
         <ul> <li><a href="dashboard.php">Dashboard</a></li> 
            <li><a href="clientes.php">Clientes</a></li> 
            <li><a href="desembolsos.php">Desembolsos</a></li>
             <li><a href="reembolsos.php">Reembolsos</a></li> 
             <li><a href="registrar.php">Utilizadores</a></li> 
             <li><a href="logout.php">Sair</a></li> 
            </ul> </div> 
            <div class="main"> 
                <div class="topbar"> 
                <h3>Registrar Novo Utilizador</h3> 
            </div> 
            <div class="card"> <h2>Dados do Utilizador</h2> 
                <form action="salvar_usuario.php" method="POST"> 
                    <div class="form-group"> <label>Nome Completo</label> 
                        <input type="text" name="nome" required> 
                    </div> 
                    <div class="form-group"> 
                        <label>Nome de Utilizador</label> 
                        <input type="text" name="username" required> 
                    </div> 
                    <div class="form-group"> 
                        <label>Senha</label> 
                        <input type="password" name="password" required> 
                    </div> 
                    <div class="form-group"> 
                        <label>Nível de Acesso</label> 
                        <select name="nivel"> 
                            <option value="Administrador">Administrador</option> 
                            <option value="Funcionário">Funcionário</option> 
                        </select> </div> 
                        <button type="submit" name="registrar" class="btn"> Registrar Utilizador </button> 
                    </form>
                 </div> 
                </div> 
            </body> 
            </html>