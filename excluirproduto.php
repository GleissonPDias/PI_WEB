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
        $stmt = $pdo->prepare('DELETE FROM produto WHERE nome = :nomeproduto OR id = :id');
        $stmt->execute([
            ':nomeproduto' => $nomeproduto,
            ':id' => $id
        ]);

        $response['success'] = true;
        $response['message'] = 'Produto DELETADO com sucesso!';
    } catch (PDOException $e) {
        $response['message'] = "Erro ao DELETAR produto: " . $e->getMessage();
    }
} else {
    $response['message'] = 'Erro: Produto não encontrado.';
}

// Retornar a resposta em formato JSON
echo json_encode($response);

?>