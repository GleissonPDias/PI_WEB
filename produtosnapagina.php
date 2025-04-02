<?php
header('Content-Type: text/html');
require('conexao_db.php');

try {
    $stmt = $pdo->prepare('SELECT * FROM produto WHERE inativo IS NULL');
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

foreach ($dados as $produtos) { 
    echo "<figure>";

    // Corrigido o erro de aspas dentro do echo
    echo '<img src="' . $produtos['imagem'] . '">';
    echo '<h1 class="nameP">' . $produtos['nome'] . '</h1>';
    echo '<button class="price">' . $produtos['preco'] . '</button>';
    echo '<p>' . $produtos['descricao'] . '</p>';

    echo "</figure>";
}
?>