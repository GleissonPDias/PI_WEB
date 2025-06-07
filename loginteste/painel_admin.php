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
            background-color: #f0f4f8; 
        }
        .card{
        background-color: #E9efff; 
         padding: 40px;
         align-items: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.97);
        border-radius:8px; 
    }
        
        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .menu a {
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            width: 200px;
            border-radius: 5px;
        }
        .menu a:hover {
           transition: 1s;
    background-color: #e1e1e1;
    color: #007bff;
    border:2px solid #007bff;
}
       .card .h2 .p{
        color: black;
       } 
       .card h2, p{
        color: black;
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
