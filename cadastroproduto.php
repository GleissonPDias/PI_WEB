<?php

require("conexao_db.php");

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
$nomeproduto = $_POST['nomeproduto'] ?? '';
$preco = $_POST['preco'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$estoque = $_POST['estoque'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$imagem = $_POST['imagem'] ?? '';

$response = [];

// Verificar se o produto já existe
try {
    $stmt = $pdo->prepare('SELECT nome FROM produto WHERE nome = :nomeproduto');
    $stmt->execute([
        ':nomeproduto' => $nomeproduto
    ]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($dados) > 0) {
        // Se o produto já existe
        $response['message'] = 'Produto já existe!';
    }
    // Inserir produto, caso os dados do produto sejam válidos
    elseif (!empty($nomeproduto) && !empty($preco) && !empty($descricao) && !empty($estoque) && !empty($categoria) && !empty($imagem)) {
        try {
            // Insere o produto no banco
            $stmt = $pdo->prepare('INSERT INTO produto (nome, preco, descricao, estoque, id_sub_categoria, imagem) VALUES (:nomeproduto, :preco, :descricao, :estoque, :categoria, :imagem)');
            $stmt->execute([
                ':nomeproduto' => $nomeproduto,
                ':preco' => $preco,
                ':descricao' => $descricao,
                ':estoque' => $estoque,
                ':categoria' => $categoria,
                ':imagem' => $imagem
            ]);
            
            $response['success'] = true;
            $response['message'] = 'Produto cadastrado com sucesso!';
        } catch (PDOException $e) {
            $response['message'] = "Erro ao cadastrar produto: " . $e->getMessage();
        }
    } else {
        $response['message'] = 'Erro: Dados do produto não estão completos.';
    }
} catch (PDOException $e) {
    $response['message'] = "Erro ao verificar produto: " . $e->getMessage();
}

// Retornar a resposta em formato JSON
echo json_encode($response);

?>