<?php
header('Content-Type: text/html');
require("conexao_db.php");



try {

    $stmt = $pdo->prepare('SELECT nome FROM categoria');
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhuma categoria encontrada.";
} else {
    foreach ($dados as $produtos) {
        echo '<br>';
        echo '<option value="' . $produtos['nome'] . '">' . $produtos['nome'] . '</option>';
        echo '</select><br>';


    
    
    }
}
?>