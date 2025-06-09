<?php
session_start();
require_once('../../conexao_db.php');

// Verifica se há um token na URL e se corresponde ao token da sessão
if (!isset($_GET['token']) || !isset($_SESSION['token_temp']) || $_GET['token'] !== $_SESSION['token_temp']) {
    $_SESSION['mensagem_erro'] = "Token inválido ou expirado";
    header("Location: redefinir_senha.php");
    exit();
}

// Processamento do formulário de nova senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    // Validações
    if (empty($nova_senha) || empty($confirmar_senha)) {
        $erro = "Por favor, preencha ambos os campos";
    } elseif ($nova_senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem";
    } elseif (strlen($nova_senha) < 8) {
        $erro = "A senha deve ter pelo menos 8 caracteres";
    } else {
        try {
            // Atualiza a senha no banco de dados (usando a mesma estrutura do seu código de edição)
            $stmt_update_adm = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_SENHA = :nova_senha WHERE ADM_ID = :adm_id");
            $stmt_update_adm->execute([
            ':adm_id' => $adm_id,
            ':nova_senha' => $nova_senha
        ]);
            
            // Limpa os dados temporários da sessão
            unset($_SESSION['token_temp']);
            unset($_SESSION['id_usuario_redefinicao']);
            
            $_SESSION['mensagem_sucesso'] = "Senha redefinida com sucesso!";
            header("Location: ../login.php");
            exit();
        } catch (PDOException $e) {
            $erro = "Erro ao atualizar senha: " . $e->getMessage();
        }
    }
    echo $nova_senha;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Nova Senha</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; 
        }

        body.body { 
            background-color: #f0f4f8; 
            display: flex; 
            justify-content: center; 
            align-items: flex-start; 
            padding: 50px 20px; 
            min-height: 100vh;  
        }

        .card {
            background-color: #E9efff;
            padding: 40px;
            border-radius: 8px;
            width:280px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.97);
        }

        h1 {
            color: #2c3e50; 
            margin-bottom: 30px;
            text-align: center; 
            font-size: 2.2em;
            font-weight: 700;
        }

        form label {
            font-weight: 600; 
            color: #4a6c89; 
            margin-bottom: 5px; 
            margin-top: 15px;
            display: block; 
            text-align: left;
        }

        form input[type="password"] {
            width: 100%;
            padding: 12px 4px;
            border: 1px solid #cce7ed;
            border-radius: 8px; 
            font-size: 1.05em;
            color: #333;
            outline: none; 
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 0; 
        }

        form input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        form button[type="submit"] {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1.05em;
            cursor: pointer; 
            font-weight: 600;
            margin-top: 30px; 
            background-color: #007bff; 
            color: white;
            display: block; 
            margin-left: auto; 
            margin-right: auto; 
            width: 100%;
        }

        form button[type="submit"]:hover {
            background-color: white; 
            transform: translateY(-2px);
            border: 2px solid #007bff;
            color: #007bff;
        }

        .erro {
            color: #721c24; 
            background-color: #f8d7da; 
            border: 1px solid #f5c6cb; 
            border-radius: 5px; 
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .voltar-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body class="body">
    <div class="card">
        <h1>Criar Nova Senha</h1>
        
        <?php if (isset($erro)): ?>
            <div class="erro"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        
        <form method="post">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" name="nova_senha" id="nova_senha" required placeholder="Mínimo 8 caracteres">
            
            <label for="confirmar_senha">Confirmar Nova Senha:</label>
            <input type="password" name="confirmar_senha" id="confirmar_senha" required placeholder="Digite novamente">
            
            <button type="submit">Redefinir Senha</button>
        </form>
        
        <a href="../login.php" class="voltar-link">← Voltar para Login</a>
    </div>
</body>
</html>