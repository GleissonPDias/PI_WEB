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
    $user_bd = $pdo->query('SELECT * FROM produto');

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
    $categoria = $_POST['categoria'];

        try {
            // Prepara a consulta para inserir um novo usuário no banco de dados
            $stmt = $pdo->prepare('INSERT INTO produto (nome, preco, descricao, estoque, id_sub_categoria) VALUES (:nomeproduto, :preco, :descricao, :estoque, :categoria)');

            // Executa a inserção passando os valores para os placeholders
            $stmt->execute([
                ':nomeproduto' => $nomeproduto,  
                ':preco' => $preco,  
                ':descricao' => $descricao,  
                ':estoque' => $estoque,
                ':categoria' => $categoria  
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