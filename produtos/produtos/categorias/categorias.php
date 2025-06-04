<?php
header('Content-Type: text/html');
require("../../../conexao_db.php");

try {
    $stmt = $pdo->prepare('SELECT * from categoria');
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhum produto encontrado.";
} else {
    echo "<table border='1' class='tabela_produtos'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Cod.</th>";
    echo "<th>Categorias</th>";
    echo "<th>Editar</th>";
    echo "<th>Apagar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($dados as $produtos) { 
        echo "<tr>";
        echo "<td id=" . $produtos['id'] . " >" . $produtos['id'] . "</td>";
        echo "<td>" . $produtos['nome'] . "</td>";
        echo "<td><button type='button' class='btn_acao editar' onclick='editarCategoria(\"" . $produtos['id'] . "\", \"" . addslashes($produtos['nome']) . "\")'>Editar</button></td>";
        echo "<td><button type='button' class='btn_acao apagar' onclick='apagarCategoria(\"" . $produtos['nome'] . "\")'>Apagar</button></td>";
        
        echo "</tr>";

}   echo "</tbody>";
    echo "</table>";
}


?>