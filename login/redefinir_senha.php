<?php
session_start();

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $_SESSION['mensagem'] = "Se o e-mail estiver cadastrado, um link de redefinição será enviado.";
    header("Location: redefinir_senha.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Redefinir Senha</title>
</head>
<body>
    <h2>Redefinição de Senha</h2>

    <?php
    if (isset($_SESSION['mensagem'])) {
        echo '<p style="color: green;">' . $_SESSION['mensagem'] . '</p>';
        unset($_SESSION['mensagem']);
    }
    ?>

    <form method="post" action="">
        <label for="email">Informe seu e-mail cadastrado:</label>
        <input type="email" id="email" name="email" required>
        <p>
        <input type="submit" value="Enviar link de redefinição">
    </form>

    <p><a href="login.php">Voltar para login</a></p>
</body>
</html>