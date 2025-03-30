<?php

header('Content-Type: application/json');

require("conexao_db.php");

$novacategoria = $_POST['novacategoria'] ?? '';

// Inserir nova categoria, caso o nome da nova categoria seja fornecido
if (!empty($novacategoria)) {
    try {
        // Insere nova categoria
        $stmt = $pdo->prepare('INSERT INTO categoria (NOME) VALUES (:novacategoria)');
        $stmt->execute([
            ':novacategoria' => $novacategoria
        ]);

        $response['success'] = true;
        $response['message'] = 'Categoria cadastrada com sucesso!';
    } catch (PDOException $e) {
        $response['message'] = "Erro ao cadastrar categoria: " . $e->getMessage();
    }
} else {
    $response['message'] = 'Erro: Nome da categoria não fornecido.';
}

// Enviar a resposta como JSON
echo json_encode($response);
?>


