<?php
header('Content-Type: text/html');
require('conexao_db.php');

try {
    $stmt = $pdo->prepare("SELECT * FROM produto WHERE carrossel IS NOT NULL");
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

foreach ($dados as $produtos) { 
    echo '<img src="' . $produtos['carrossel'] . '">';
}
?>