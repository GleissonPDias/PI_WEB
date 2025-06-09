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
    <link rel="stylesheet" href="style.login.css">
    <title>Login do Administrador</title>
</head>
<body class="body">
    <div id="login">

            <div class="card">

                <div class="card-header">

    <h2>Login do Administrador</h2>
    <form action="processa_login.php" method="post">
        </div>

                <div class="card-content">

                    <div class="card-content-area">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
         </div>

                    <div class="card-content-area">
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        </div>

                </div>
        <div class="card-footer">
        <input  type="submit" value="Entrar" class="submit">
        </div>
        
    </form>
        <p><a href="redefinir_senha.php">Esqueci minha senha</a></p>
</div>

        </div>
</body>
</html>