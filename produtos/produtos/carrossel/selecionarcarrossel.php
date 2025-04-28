<?php
header('Content-Type: text/html');
require("../../../conexao_db.php");

try {
    $stmt = $pdo->prepare('SELECT id from carrossel');
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhum produto encontrado.";
} else {
    echo '<label>Selecione o Carrossel: </label>';
    echo '<select id="selecionarcarrossel">';

    foreach ($dados as $carrossel) { 
        echo '<option value="' . $carrossel['id'] . '">' . $carrossel['id'] . '</option>';
    }
    echo '</select>';

    echo '<label for="imagemcarrossel">Imagem do Carrossel: </label>';
    echo '<input type="text" id="imagemcarrossel">';
    echo '<button onclick="addimagemcarrossel()">Adicionar imagem</button>';
    

}


?>