<?php

require("../../../conexao_db.php");

header('Content-Type: application/json');

// Verificar se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método de requisição inválido. Utilize POST.'
    ]);
    exit; // Encerra a execução do script
}

// Verificar os dados recebidos
$id = $_POST['id'] ?? '';
$nomeproduto = $_POST['nomeproduto'] ?? '';
$preco = $_POST['preco'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$estoque = $_POST['estoque'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$subcategoria = $_POST['subcategoria'] ?? '';
$imagem = rtrim($_POST['imagem'] ?? '', '}');  // Certifique-se de que isso está correto para o seu caso

$response = [];

// Verificar se todos os dados obrigatórios estão presentes
if (
    $nomeproduto === '' ||
    $preco === '' ||
    $descricao === '' ||
    $estoque === '' ||
    $categoria === '' ||
    $subcategoria === '' ||
    $imagem === ''
) {
    $response['error'] = 'Todos os campos devem ser preenchidos.';
} else {
    // Verificar se o produto já existe e se podemos atualizar
    try {
        if ($estoque < 1) {
            $stmt = $pdo->prepare('UPDATE produto SET nome = :nomeproduto, preco = :preco, descricao = :descricao, estoque = :estoque, id_categoria = :categoria, id_sub_categoria = :subcategoria, imagem = :imagem, inativo = NULL WHERE id = :id');
        } else {
            $stmt = $pdo->prepare('UPDATE produto SET nome = :nomeproduto, preco = :preco, descricao = :descricao, estoque = :estoque, id_categoria = :categoria, id_sub_categoria = :subcategoria, imagem = :imagem, inativo = 1 WHERE id = :id');
        }
    
        $stmt->execute([
            ':id' => $id,
            ':nomeproduto' => $nomeproduto,
            ':preco' => $preco,
            ':descricao' => $descricao,
            ':estoque' => $estoque,
            ':categoria' => $categoria,
            ':subcategoria' => $subcategoria,
            ':imagem' => $imagem
        ]);

        // Verificar se a atualização foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            $response['success'] = 'Produto atualizado com sucesso!';
        } else {
            $response['error'] = 'Nenhuma alteração realizada. Verifique se os dados são diferentes dos já existentes.';
        }

    } catch (PDOException $e) {
        $response['error'] = 'Erro ao atualizar o produto: ' . $e->getMessage();
    }
}

// Retornar a resposta como JSON
echo json_encode($response);