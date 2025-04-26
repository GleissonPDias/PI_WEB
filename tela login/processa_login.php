<?php
session_start();

$nome = $_POST['usuario'];
$senha = $_POST['senha'];

// ✅ Usuário de teste padrão (sem banco)
if ($nome === 'admin' && $senha === '1234') {
    $_SESSION['admin'] = true;
    header('Location: admin.php');
    exit;
}

try {
    require_once('conexao_db.php');

    $sql = "SELECT * FROM ADMINISTRADOR WHERE ADM_NOME = :nome AND ADM_SENHA = :senha AND ADM_ATIVO = 1"; 
    $query = $pdo->prepare($sql);
    $query->bindParam(':nome', $nome, PDO::PARAM_STR); 
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $_SESSION['admin'] = true;
        header('Location: admin.php'); 
        exit;
    } else {
        $_SESSION['mensagem_erro'] = "NOME DE USUÁRIO OU SENHA INCORRETO";
        header('Location: login.php');
        exit;
    }
} catch (Exception $e) {
    $_SESSION['mensagem_erro'] = "Erro de conexão: " . $e->getMessage();
    header('Location: login.php');
    exit;
}
?>
