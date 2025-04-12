<?php
header('Content-Type: text/html');
require("conexao_db.php");



try {

    $stmt = $pdo->prepare('SELECT nome FROM categoria');
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    die("Erro na consulta: " . $e->getMessage());
}



if (empty($categorias)) {
    echo "Nenhuma categoria encontrada.";
} else {
    foreach ($categorias as $categoria) {
        echo '<br>';
        echo '<option value="' . $categoria['nome'] . '">' . $categoria['nome'] . '</option>';
        echo '</select><br>';
    }
}
?>