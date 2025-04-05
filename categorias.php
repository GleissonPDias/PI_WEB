<?php
header('Content-Type: text/html');
require("conexao_db.php");

try {
    $stmt = $pdo->prepare('SELECT NOME from categoria');
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhum produto encontrado.";
} else {

    foreach ($dados as $produtos) { 
        echo '<option value="' . $produtos['NOME'] . '">' . $produtos['NOME'] . '</option>';

}}


?>