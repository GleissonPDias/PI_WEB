<?php
header('Content-Type: text/html');
require("conexao_db.php");

$nome = $_POST['nome'] ?? '';
$id = $_POST['id'] ?? '';

try {
    $stmt = $pdo->prepare('SELECT * FROM produto WHERE nome = :nome OR id = :id');
    $stmt->execute([
        ':nome' => $nome,
        ':id' => $id
    ]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhum produto encontrado.";
} else {


    foreach ($dados as $produtos) { 
        echo "<tr>";
        echo '<input type="text" value="' . $produtos['id'] . '">';
        echo '<input type="text" value="' . $produtos['nome'] . '">';
        echo "<td>" . $produtos['preco'] . "</td>";
        echo "<td>" . $produtos['descricao'] . "</td>";
        echo "<td>" . $produtos['id_sub_categoria'] . "</td>";
        echo "<td>" . $produtos['estoque'] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
?>