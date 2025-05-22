<?php
session_start();
if (!isset($_SESSION['admin'])) {
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
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Bem-vindo ao Painel do Administrador</h2>
    <p>Escolha uma das opções abaixo:</p>

    <div class="menu">
        <a href="/pi_web/produtos/produtos/produtos.html">Gerenciar Produtos</a>
        <a href="usuarios.php">Visualizar Usuários</a>
        <a href="logout.php">Sair</a>
    </div>
</body>
</html>
