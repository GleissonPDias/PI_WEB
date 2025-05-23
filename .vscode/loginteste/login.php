<?php
session_start();

if(isset($_SESSION['mensagem_erro'])) {
    echo '<p style="color: red;">' . htmlspecialchars($_SESSION['mensagem_erro']) . '</p>';
    unset($_SESSION['mensagem_erro']); 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login do Administrador</title>
</head>
<body>
    <h2>Login do Administrador</h2>
    <form action="processa_login.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <p>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <p>
        <input type="submit" value="Entrar">
    </form>
</body>
</html>