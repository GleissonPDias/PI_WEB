<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: admin.php"); // Redireciona se já estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php
    if (isset($_SESSION['mensagem_erro'])) {
        echo "<p style='color:red'>" . $_SESSION['mensagem_erro'] . "</p>";
        unset($_SESSION['mensagem_erro']);
    }
    ?>

    <form method="POST" action="processa_login.php">
        <label>Usuário:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <input type="submit" value="Entrar">
    </form>

    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
    <p>Esqueceu sua senha? <a href="redefinir_senha.php">Redefinir senha</a></p>
</body>
</html>
