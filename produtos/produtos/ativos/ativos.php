<?php
header('Content-Type: text/html');
require("../../../conexao_db.php");

try {
    $stmt = $pdo->prepare('SELECT * FROM produto WHERE inativo IS NOT NULL');
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhum produto encontrado.";
} else {
    echo "<table border='1' class='tabela_produtos'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Cod.Produto</th>";
    echo "<th>Nome</th>";
    echo "<th>Preço</th>";
    echo "<th>Descrição</th>";
    echo "<th>Categoria</th>";
    echo "<th>Sub Categoria</th>";
    echo "<th>Estoque</th>";
    echo "<th>Inativar</th>"; 
    echo "<th>Editar</th>";
    echo "<th>Apagar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($dados as $produtos) {
        echo "<tr>";
        echo "<td>" . $produtos['id'] . "</td>";
        echo "<td>" . $produtos['nome'] . "</td>";
        echo "<td> R$" . $produtos['preco'] . "</td>";
        echo "<td>" . $produtos['descricao'] . "</td>";
        echo "<td>" . $produtos['id_categoria'] . "</td>";
        echo "<td>" . $produtos['id_sub_categoria'] . "</td>";
        echo "<td>" . $produtos['estoque'] . "</td>";

        echo "<td><button type='button' class='btn_acao inativar' onclick='inativar(" . $produtos['id'] . ")'>Inativar</button></td>";
        echo "<td><button type='button' class='btn_acao editar' onclick='loceditar(" . $produtos['id'] . ")'>Editar</button></td>";
        echo "<td><button type='button' class='btn_acao apagar' onclick='apagarProduto(" . $produtos['id'] . ")'>Apagar</button></td>";

        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
?>