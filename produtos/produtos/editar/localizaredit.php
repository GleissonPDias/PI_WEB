<?php
header('Content-Type: text/html');
require("../../../conexao_db.php");

$id = $_POST['id'] ?? '';

try {

    $stmt = $pdo->prepare('SELECT nome, id FROM categoria');
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    die("Erro na consulta: " . $e->getMessage());
}

try {

    $stmt = $pdo->prepare('SELECT nome, id FROM sub_categoria');
    $stmt->execute();
    $subcategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    die("Erro na consulta: " . $e->getMessage());
}

try {

    $stmt = $pdo->prepare('SELECT * FROM produto WHERE id = :id');
    $stmt->execute([

        ':id' => $id
    ]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    die("Erro na consulta: " . $e->getMessage());
}

if (empty($dados)) {
    echo "Nenhum produto encontrado.";
} else {
    foreach ($dados as $produtos) {
        echo '<table border="1">';
        echo '<br>';
        echo '<label for="idedit">Cod. Produto</label>';
        echo '<input id="idedit" type="text" value="' . $produtos['id'] . '" disabled> <br>';  // Adicionei disabled para não permitir editar o ID
        echo '<label for="nomeedit">Nome</label>';
        echo '<input id="nomeedit" type="text" value="' . $produtos['nome'] . '"><br>';
        
        // Criando o campo de seleção de categoria
        echo '<label for="categoriaedit">Categoria</label>';
        echo '<select id="categoriaedit">';
        
        // Preenchendo o select com categorias
        foreach ($categorias as $categoria) {
            $selectedcat = ($produtos['id_categoria'] == $categoria['id']) ? 'selected' : ''; // Verifica se a categoria do produto é a mesma
            echo '<option value="' . $categoria['nome'] . '" ' . $selectedcat . '>' . $categoria['nome'] . '</option>';
        }
        echo '</select><br>';


        echo '<label for="subcategoriaedit">Sub Categoria</label>';
        echo '<select id="subcategoriaedit">';
        
        // Preenchendo o select com categorias
        foreach ($subcategorias as $subcategoria) {
            $selected = ($produtos['id_sub_categoria'] == $subcategoria['id']) ? 'selected' : ''; // Verifica se a categoria do produto é a mesma
            echo '<option value="' . $subcategoria['nome'] . '" ' . $selected . '>' . $subcategoria['nome'] . '</option>';
        }
        echo '</select><br>';



        echo '<label for="precoedit">Preço</label>';
        echo '<input id="precoedit" type="text" value="' . $produtos['preco'] . '"><br>';

        echo '<label for="descedit">Descrição</label>';
        echo '<textarea id="descedit">' . $produtos['descricao'] . '</textarea><br>';

        echo '<label for="estoqueedit">Estoque</label>';
        echo '<input id="estoqueedit" type="text" value="' . $produtos['estoque'] . '"><br>';

        echo '<label for="imagemedit">Imagem</label>';
        echo '<input id="imagemedit" type="text" value="' . $produtos['imagem'] . '"><br> <br> <br>';

        echo "<button type='button' onclick='editar(" . $produtos['id'] . "); '>Confirmar Edição</button>";
        echo "<button type='button' onclick='cancelaredicao()'>Cancelar Edição</button>";


        echo '</table>';
    
    
    
    }
}
?>