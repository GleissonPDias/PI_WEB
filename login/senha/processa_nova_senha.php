<?php
session_start();
require_once('../../conexao_db.php');

if(session_status() !== PHP_SESSION_ACTIVE) {
    die("Sessão não está ativa");
}

if(!isset($_SESSION['id_usuario_redefinicao'])) {
    error_log("Tentativa de acesso não autorizado. Sessão: " . print_r($_SESSION, true));
    
    $_SESSION['mensagem_erro'] = "Sessão expirada. Por favor, inicie o processo novamente.";
    header("Location: redefinir_senha.php");
    exit();
}

$nova_senha = $_POST['nova_senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';
$id_usuario = $_SESSION['id_usuario_redefinicao'];

if(empty($nova_senha) || empty($confirmar_senha)) {
    $_SESSION['mensagem_erro'] = "Por favor, preencha ambos os campos de senha.";
    header("Location: nova_senha.php");
    exit();
}

if($nova_senha !== $confirmar_senha) {
    $_SESSION['mensagem_erro'] = "As senhas não coincidem.";
    header("Location: nova_senha.php");
    exit();
}

if(strlen($nova_senha) < 6) {
    $_SESSION['mensagem_erro'] = "A senha deve ter pelo menos 6 caracteres.";
    header("Location: nova_senha.php");
    exit();
}

try {
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_SENHA = ? WHERE ADM_ID = ?");
    
    error_log("Executando query: UPDATE ADMINISTRADOR SET ADM_SENHA = ? WHERE ADM_ID = $id_usuario");
    
    $stmt->execute([$senha_hash, $id_usuario]);

    if($stmt->rowCount() === 0) {
        throw new PDOException("Nenhum registro foi atualizado");
    }

    error_log("Senha atualizada com sucesso para o usuário ID: $id_usuario");

    unset($_SESSION['id_usuario_redefinicao']);

    session_regenerate_id(true);
    
    $_SESSION['mensagem_sucesso'] = "Senha redefinida com sucesso!";

    error_log("Redirecionando para login.php");
    
    header("Location: login.php");
    exit();

} catch(PDOException $e) {
    error_log("Erro ao atualizar senha: " . $e->getMessage());
    
    $_SESSION['mensagem_erro'] = "Erro ao redefinir senha. Por favor, tente novamente.";
    header("Location: nova_senha.php");
    exit();
}
?>