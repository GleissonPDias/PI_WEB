<?php
session_start();

try {
    // Verifica se os dados foram enviados
    if (empty($_POST['nome']) || empty($_POST['senha'])) {
        throw new Exception("Preencha todos os campos");
    }

    // Inclui o arquivo de conexão
    require_once('../conexao_db.php');
    
    // Limpa e armazena os dados
    $nome = trim($_POST['nome']);
    $senha = trim($_POST['senha']);
    
    // Verifica se a tabela ADMINISTRADOR existe
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='ADMINISTRADOR'");
    if ($stmt->fetch() === false) {
        throw new PDOException("Tabela ADMINISTRADOR não encontrada no banco de dados");
    }
    
    // Prepara e executa a consulta
    $sql = "SELECT * FROM ADMINISTRADOR WHERE ADM_NOME = :nome AND ADM_SENHA = :senha AND ADM_ATIVO = 1"; 
    $query = $pdo->prepare($sql);
    
    $query->bindValue(':nome', $nome, PDO::PARAM_STR);
    $query->bindValue(':senha', $senha, PDO::PARAM_STR);
    
    if (!$query->execute()) {
        $errorInfo = $query->errorInfo();
        throw new PDOException("Erro ao executar consulta: " . $errorInfo[2]);
    }
    
    $usuario = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario) {
        $_SESSION['admin_logado'] = true;
        $_SESSION['admin_nome'] = $nome;
        $_SESSION['admin_id'] = $usuario['ID']; // Assumindo que existe um campo ID
        header('Location: admin.php'); 
        exit;
    } else {
        $_SESSION['mensagem_erro'] = "Credenciais inválidas ou usuário inativo";
        header('Location: login.php');
        exit;
    }
} catch (PDOException $e) {
    error_log("Erro PDO: " . $e->getMessage());
    $_SESSION['mensagem_erro'] = "Erro no sistema. Por favor, tente novamente.";
    header('Location: login.php');
    exit;
} catch (Exception $e) {
    error_log("Erro: " . $e->getMessage());
    $_SESSION['mensagem_erro'] = $e->getMessage();
    header('Location: login.php');
    exit;
}