<?php
session_start();
if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Painel do Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
                background-color: #454d6b;
        }
        .card{
        background: rgba(19, 19, 19, 0.3);
         padding: 40px;
         align-items: center;
         border: 2px solid black;
    }
        
        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .menu a {
            padding: 10px;
            background-color: #a13854;
            color: white;
            text-decoration: none;
            width: 200px;
            border-radius: 5px;
        }
        .menu a:hover {
           transition: 1s;
    background-color: #e1e1e1;
    color: #a13854;
}
       .card .h2 .p{
        color: white;
       } 
    </style>
</head>
<body>
    <div class="card">
    <h2>Bem-vindo ao Painel do Administrador</h2>
    <p>Escolha uma das opções abaixo:</p>

    <div class="menu">
        <a href="/pi_web/produtos/produtos/produtos.html">Gerenciar Produtos</a>
        <a href="listar_administrador.php">Visualizar Usuários</a>
        <a href="logout.php">Sair</a>
    </div>
    </div>
</body>
</html>
