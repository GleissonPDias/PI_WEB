<?php

header('Content-Type: application/json');

require("../../../conexao_db.php");
$novacategoria = $_POST['novacategoria'] ?? '';

$response = [];

// Verifica se a categoria já existe no banco
try {
    $stmt = $pdo->prepare('SELECT NOME FROM categoria WHERE NOME = :novacategoria');
    $stmt->execute([
        ':novacategoria' => $novacategoria
    ]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($dados) > 0) {
        // Se a categoria já existe
        $response['message'] = 'Categoria já existe!';
    } elseif (!empty($novacategoria)) {
        // Se a categoria não existe, insere a nova categoria
        try {
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
        // Caso o nome da categoria não tenha sido fornecido
        $response['message'] = 'Erro: Nome da categoria não fornecido.';
    }
} catch (PDOException $e) {
    $response['message'] = "Erro ao verificar categoria: " . $e->getMessage();
}

// Enviar a resposta como JSON
echo json_encode($response);

?>