<?php

require("conexao_db.php");

header('Content-Type: application/json');


$nomeproduto = $_POST['nomeproduto'] ?? '';
$id = $_POST['id'] ?? '';

// Inicializando a resposta
$response = [
    'success' => false,
    'message' => 'Erro desconhecido.'
];

// Inserir produto, caso os dados do produto sejam válidos
if (!empty($nomeproduto)) {
    try {
        // Insere o produto no banco
        $stmt = $pdo->prepare('UPDATE produto SET inativo = NULL WHERE nome = :nomeproduto OR id = :id');
        $stmt->execute([
            ':nomeproduto' => $nomeproduto,
            ':id' => $id
        ]);

        $response['success'] = true;
        $response['message'] = 'Produto inativado com sucesso!';
    } catch (PDOException $e) {
        $response['message'] = "Erro ao inativar produto: " . $e->getMessage();
    }
} else {
    $response['message'] = 'Erro: Produto não encontrado.';
}

// Retornar a resposta em formato JSON
echo json_encode($response);

?>