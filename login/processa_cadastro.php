<?php
session_start();

// Configurações do banco de dados
$host = 'localhost';
$db = 'nome_do_seu_banco';
$user = 'usuario_do_banco';
$pass = 'senha_do_banco';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recebendo dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verifica se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        $_SESSION['mensagem_erro'] = "As senhas não coincidem!";
        header("Location: cadastro.php");
        exit();
    }

    // Verifica se o e-mail já está cadastrado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['mensagem_erro'] = "E-mail já cadastrado!";
        header("Location: cadastro.php");
        exit();
    }

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere novo usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
    $stmt->execute([
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha_hash
    ]);

    $_SESSION['mensagem_sucesso'] = "Cadastro realizado com sucesso!";
    header("Location: cadastro.php");
    exit();

} catch (PDOException $e) {
    $_SESSION['mensagem_erro'] = "Erro no banco de dados: " . $e->getMessage();
    header("Location: cadastro.php");
    exit();
}
