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

$imagem = rtrim($_POST['imagem'] ?? '', '}');
$response = [];


if (!empty($imagem)) {
    try {
            // Insere o produto no banco
        $stmt = $pdo->prepare('INSERT INTO produto (carrossel) VALUES (:imagem)');
        $stmt->execute([
            ':imagem' => $imagem
        ]);
            
        $response['success'] = true;
        $response['message'] = 'Imagem cadastrada com sucesso!';
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = "Erro ao cadastrar imagem: " . $e->getMessage();
}
    } else {
        $response['success'] = false;
        $response['message'] = 'Erro: Dados do produto não estão completos.';
}


// Retornar a resposta em formato JSON
echo json_encode($response);

?>