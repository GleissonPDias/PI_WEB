<?php
session_start();

if (isset($_SESSION['mensagem_erro'])) {
    echo '<p style="color: red;">' . $_SESSION['mensagem_erro'] . '</p>';
    unset($_SESSION['mensagem_erro']);
}

if (isset($_SESSION['mensagem_sucesso'])) {
    echo '<p style="color: green;">' . $_SESSION['mensagem_sucesso'] . '</p>';
    unset($_SESSION['mensagem_sucesso']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Usuário</title>
    <script>
        function validarFormulario() {
            const senha = document.getElementById("senha").value;
            const confirmar = document.getElementById("confirmar_senha").value;

            if (senha !== confirmar) {
                alert("As senhas não coincidem.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <h2>Cadastro</h2>
    <form action="processa_cadastro.php" method="post" onsubmit="return validarFormulario();">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <p>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <p>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" placeholder="Mínimo de 6 caracteres" required>
        <p>

        <label for="confirmar_senha">Confirme a Senha:</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Mínimo de 6 caracteres" required>
        <p>

        <input type="submit" value="Criar usuário">
    </form>

    <p><a href="login.php">Voltar</a></p>
</body>
</html>
