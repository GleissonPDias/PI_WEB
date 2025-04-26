<?php

require("conexao_db.php");

try {
    // Consulta todos os usuários do banco de dados
    $user_bd = $pdo->query('SELECT * FROM usuarios');

    // Obtém os dados retornados pela consulta e os armazena em um array associativo
    $dados = $user_bd->fetchAll(PDO::FETCH_ASSOC);

    // Verifica se existem usuários cadastrados
    if ($dados) {
        echo '<pre>'; // Formata a saída no navegador
        print_r($dados); // Exibe os dados do banco de forma legível
    } else {
        echo "Nenhum usuário encontrado."; // Exibe mensagem caso o banco esteja vazio
    }
} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];

    // Verifica se a senha e a confirmação da senha são iguais
    if ($_POST['password'] === $_POST['confirm-password']) {
        // Criptografa a senha usando BCRYPT para segurança
        $senha = password_hash($_POST['password'], PASSWORD_BCRYPT);

        try {
            // Prepara a consulta para inserir um novo usuário no banco de dados
            $stmt = $pdo->prepare('INSERT INTO usuarios (cpf, email, nome, senha_hash, telefone, tipo) VALUES (:cpf, :email, :nome, :senha, :telefone, :tipo)');

            // Executa a inserção passando os valores para os placeholders
            $stmt->execute([
                ':nome' => $nome,  // Substitui :nome pelo valor da variável $usuario
                ':email' => $email,   // Substitui :email pelo valor da variável $email
                ':senha' => $senha,   // Substitui :senha pelo hash da senha
                ':telefone' => $telefone,
                ':tipo' => 'usuario'
            ]);

            echo "Usuário cadastrado com sucesso!"; // Exibe mensagem de sucesso
        } catch (PDOException $e) {
            // Se houver erro na inserção, exibe a mensagem de erro
            die("Erro ao cadastrar usuário: " . $e->getMessage());
        }
    } else {
        // Se as senhas não forem iguais, exibe uma mensagem de erro
        echo "As senhas não coincidem!";
    }
}
?>

