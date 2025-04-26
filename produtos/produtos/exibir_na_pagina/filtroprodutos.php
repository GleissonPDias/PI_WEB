<?php
header('Content-Type: text/html; charset=utf-8');
require('conexao_db.php');

$categoria = $_POST['categoria'] ?? '';
$subcategoria = $_POST['subcategoria'] ?? '';
$preco = $_POST['preco'] ?? '';
$nome = $_POST['nome'] ?? '';
$pesquisa = $_POST['pesquisa'] ?? '';

$sql = "SELECT * FROM produto WHERE inativo IS NOT NULL";
$params = [];

// Filtro por categoria
if (!empty($categoria)) {
    $sql .= " AND id_categoria = :categoria";
    $params[':categoria'] = $categoria;
}

if (!empty($subcategoria)) {
    $sql .= " AND id_sub_categoria = :subcategoria";
    $params[':subcategoria'] = $subcategoria;
}

// Filtro por nome (pesquisa por nome parcial)
if (!empty($pesquisa)) {
    $sql .= " AND nome LIKE :pesquisa";
    $params[':pesquisa'] = "%" . $pesquisa . "%";
}

// Ordenação por preço ou nome
if ($preco === "asc") {
    $sql .= " ORDER BY preco ASC";
} elseif ($preco === "desc") {
    $sql .= " ORDER BY preco DESC";
} elseif ($nome === "az") {
    $sql .= " ORDER BY nome ASC";
} elseif ($nome === "za") {
    $sql .= " ORDER BY nome DESC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($produtos) > 0) {
    foreach ($produtos as $produto) {
        echo '<figure id="' . $produto['id_categoria'] . '">';

        // Corrigido o erro de aspas dentro do echo
        echo '<img src="' . $produto['imagem'] . '">';
        echo '<h1 class="nameP">' . $produto['nome'] . '</h1>';
        echo '<button type="button" class="price">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</button>';
        echo '<p>' . $produto['descricao'] . '</p>';
        echo "</figure>";
    }
} else {
    echo "Nenhum produto encontrado.";
}
?>