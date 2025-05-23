<?php
header('Content-Type: text/html');
require("../../../conexao_db.php");

try {
    $stmt = $pdo->prepare('SELECT * FROM categoria');
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhuma categoria encontrada.";
} else {
    echo "<table border='1'>";
    echo "<thead><tr><th>Cod.</th><th>Categoria</th><th>Editar</th><th>Apagar</th></tr></thead>";
    echo "<tbody>";
    foreach ($dados as $categoria) {
        echo "<tr>";
        echo "<td id='id-{$categoria['id']}'>{$categoria['id']}</td>";
        echo "<td id='nome-{$categoria['id']}'>{$categoria['nome']}</td>";
        echo "<td><button type='button' onclick='editarCategoria({$categoria['id']})'>Editar</button></td>";
        echo "<td><button type='button' onclick='apagarCategoria({$categoria['id']})'>Apagar</button></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>