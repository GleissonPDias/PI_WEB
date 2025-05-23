<?php

require("/pi_web/conexao_db.php");

header('Content-Type: application/json');

// Verificar se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método de requisição inválido. Utilize POST.'
    ]);
    exit;
}

// Verificar os dados recebidos
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

$response = [];

// Validações básicas
if (empty($nome)) {
    $response['message'] = 'O campo nome é obrigatório.';
} elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Por favor, insira um e-mail válido.';
} elseif (empty($senha) || strlen($senha) < 6) {
    $response['message'] = 'A senha deve ter pelo menos 6 caracteres.';
} elseif ($senha !== $confirmar_senha) {
    $response['message'] = 'As senhas não coincidem.';
} else {
    // Verificar se o usuário já existe
    try {
        $stmt = $pdo->prepare('SELECT email FROM usuarios WHERE email = :email');
        $stmt->execute([
            ':email' => $email
        ]);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($dados) > 0) {
            $response['message'] = 'Este e-mail já está cadastrado!';
        } else {
            // Inserir usuário
            try {
                // Hash da senha (usando bcrypt)
                $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
                
                $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha, data_criacao) 
                                      VALUES (:nome, :email, :senha, CURRENT_TIMESTAMP)');
                $stmt->execute([
                    ':nome' => $nome,
                    ':email' => $email,
                    ':senha' => $senha_hash
                ]);
                
                $response['success'] = true;
                $response['message'] = 'Usuário cadastrado com sucesso!';
            } catch (PDOException $e) {
                $response['message'] = "Erro ao cadastrar usuário: " . $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        $response['message'] = "Erro ao verificar usuário: " . $e->getMessage();
    }
}

// Retornar a resposta em formato JSON
echo json_encode($response);
?>