<?php

require("../../../conexao_db.php");

header('Content-Type: application/json');


$id = $_POST['id'] ?? '';

// Inicializando a resposta
$response = [
    'success' => false,
    'message' => 'Erro desconhecido.'
];

// Inserir produto, caso os dados do produto sejam válidos

 try {
        // Insere o produto no banco
        $stmt = $pdo->prepare('UPDATE produto SET inativo = 1 WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);

        $response['success'] = true;
        $response['message'] = 'Produto ativado com sucesso!';
} catch (PDOException $e) {
        $response['message'] = "Erro ao ativar produto: " . $e->getMessage();
}


// Retornar a resposta em formato JSON
echo json_encode($response);

?>