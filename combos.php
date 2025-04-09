<?php
header('Content-Type: text/html');
require('conexao_db.php');

try {
    $stmt = $pdo->prepare("SELECT * FROM produto WHERE inativo IS NOT NULL AND id_sub_categoria = 'COMBOS'");
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

foreach ($dados as $produtos) { 
;
    echo '<figure id="' . $produtos['id_sub_categoria'] . '">';

    // Corrigido o erro de aspas dentro do echo
    echo '<img src="' . $produtos['imagem'] . '">';
    echo '<h1 class="nameP">' . $produtos['nome'] . '</h1>';
    echo '<button type="button" class="price">R$ ' . number_format($produtos['preco'], 2, ',', '.') . '</button>';
    echo '<p>' . $produtos['descricao'] . '</p>';
    echo "</figure>";

}
?>