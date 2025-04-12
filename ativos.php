<?php
header('Content-Type: text/html');
require("conexao_db.php");

try {
    $stmt = $pdo->prepare('SELECT * FROM produto WHERE inativo IS NOT NULL');
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhum produto encontrado.";
} else {
    echo "<table border='1'>";  // Adicionando borda à tabela para visualização
    echo "<thead>";
    echo "<tr>";
    echo "<th>Cod.Produto</th>";
    echo "<th>Nome</th>";
    echo "<th>Preço</th>";
    echo "<th>Descrição</th>";
    echo "<th>Categoria</th>";
    echo "<th>Sub Categoria</th>";
    echo "<th>Estoque</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($dados as $produtos) { 
        echo "<tr>";
        echo "<td>" . $produtos['id'] . "</td>";
        echo "<td>" . $produtos['nome'] . "</td>";
        echo "<td>" . $produtos['preco'] . "</td>";
        echo "<td>" . $produtos['descricao'] . "</td>";
        echo "<td>" . $produtos['id_categoria'] . "</td>";
        echo "<td>" . $produtos['id_sub_categoria'] . "</td>";
        echo "<td>" . $produtos['estoque'] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
?>