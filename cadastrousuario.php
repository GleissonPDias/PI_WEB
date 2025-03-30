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
    $usuario = $_POST['username']; // Nome do usuário
    $email = $_POST['email']; // E-mail do usuário

    // Verifica se a senha e a confirmação da senha são iguais
    if ($_POST['password'] === $_POST['confirm-password']) {
        // Criptografa a senha usando BCRYPT para segurança
        $senha = password_hash($_POST['password'], PASSWORD_BCRYPT);

        try {
            // Prepara a consulta para inserir um novo usuário no banco de dados
            $stmt = $pdo->prepare('INSERT INTO usuarios (username, email, senha, tipo) VALUES (:nome, :email, :senha, :papel)');

            // Executa a inserção passando os valores para os placeholders
            $stmt->execute([
                ':nome' => $usuario,  // Substitui :nome pelo valor da variável $usuario
                ':email' => $email,   // Substitui :email pelo valor da variável $email
                ':senha' => $senha,   // Substitui :senha pelo hash da senha
                ':papel' => 'admin'   // Define o papel como "admin"
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


<!-- Exibir itens do banco de dados no site php -->
 
<!DOCTYPE html> 
<html> 
  <head> 
    <meta charset="UTF-8"> 
    <title>Tutorial</title> 
  </head> 
  <body> 
    <table border="1"> 
      <tr> 
        <td>Código</td> 
        <td>Nome</td> 
        <td>E-mail</td> 
        <td>Data de Cadastro</td> 
        <td>Ação</td> 
      </tr> 
      <?php foreach ($dados as $usuario) { ?> 
      <tr> 
        <td><?php echo $usuario['id']; ?></td> <!-- Supondo que 'id' seja o código do usuário -->
        <td><?php echo $usuario['username']; ?></td>
        <td><?php echo $usuario['email']; ?></td> 
        <td><!-- Aqui você pode adicionar ações como editar ou excluir --></td>
      </tr> 
      <?php } ?> 
    </table> 
  </body> 
</html>