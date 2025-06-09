<?php
session_start();
require_once('../../conexao_db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$nome_usuario = $_POST['nome_usuario'] ?? '';
$frase_seguranca = $_POST['frase_seguranca'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT ADM_ID FROM ADMINISTRADOR WHERE ADM_NOME = ? AND frase_seguranca = ?");
    $stmt->execute([$nome_usuario, $frase_seguranca]);
    $usuario = $stmt->fetch();

    if($usuario) {
        if(session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['id_usuario_redefinicao'] = $usuario['id'];
            
            error_log("Sessão criada para ID: " . $usuario['id']);
            
            $token = bin2hex(random_bytes(16));
            $_SESSION['token_temp'] = $token;
            header("Location: nova_senha.php?token=".$token);
            exit();
        } else {
            throw new Exception("Sessão não está ativa");
        }
    } else {
        $_SESSION['mensagem_erro'] = "Credenciais inválidas";
        header("Location: redefinir_senha.php");
        exit();
    }
} catch(Exception $e) {
    $_SESSION['mensagem_erro'] = "Erro: " . $e->getMessage();
    header("Location: redefinir_senha.php");
    exit();
}
?>