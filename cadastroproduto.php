<?php
try {
    // Conectar ao banco de dados SQLite
    $pdo = new PDO('sqlite:bancodedados.db'); // Abre conexão com o arquivo demo.db
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura para exibir erros como exceções
} catch (PDOException $e) {
    // Se ocorrer um erro na conexão, exibe a mensagem e interrompe o script
    die("Erro na conexão: " . $e->getMessage());
}
try {
    // Consulta todos os usuários do banco de dados
    $user_bd = $pdo->query('SELECT * FROM produtos');

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
    $nomeproduto = $_POST['nomeproduto'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $estoque = $_POST['estoque']; 

        try {
            // Prepara a consulta para inserir um novo usuário no banco de dados
            $stmt = $pdo->prepare('INSERT INTO produto (nome, preco, descricao, estoque) VALUES (:nomeproduto, :preco, :descricao, :estoque)');

            // Executa a inserção passando os valores para os placeholders
            $stmt->execute([
                ':nomeproduto' => $nomeproduto,  
                ':preco' => $preco,  
                ':descricao' => $descricao,  
                ':estoque' => $estoque  
            ]);

            echo "Usuário cadastrado com sucesso!"; // Exibe mensagem de sucesso
        } catch (PDOException $e) {
            // Se houver erro na inserção, exibe a mensagem de erro
            die("Erro ao cadastrar usuário: " . $e->getMessage());
        }
    } else {
        // Se as senhas não forem iguais, exibe uma mensagem de erro
        echo "As senhas não coincidem!";
    };
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