
<?php

header('Content-Type: application/json');

require("../../../conexao_db.php");

$novasubcategoria = $_POST['novasubcategoria'] ?? '';
$id_categoria = $_POST['id_categoria'] ?? '';

$response = [];

try {
    $stmt = $pdo->prepare('SELECT nome FROM sub_categoria WHERE nome = :novasubcategoria');
    $stmt->execute([
        ':novasubcategoria' => $novasubcategoria
    ]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($dados) > 0) {
        // Se a categoria já existe
        $response['message'] = 'Categoria já existe!';
    } elseif (!empty($novasubcategoria)) {
        // Se a categoria não existe, insere a nova categoria
        try {
            $stmt = $pdo->prepare('INSERT INTO sub_categoria (nome, id_categoria) VALUES (:novasubcategoria, :id_categoria)');
            $stmt->execute([
                ':novasubcategoria' => $novasubcategoria,
                ':id_categoria' => $id_categoria
            ]);

            $response['success'] = true;
            $response['message'] = 'Sub Categoria cadastrada com sucesso!';
        } catch (PDOException $e) {
            $response['message'] = "Erro ao cadastrar sub categoria: " . $e->getMessage();
        }
    } else {
        // Caso o nome da categoria não tenha sido fornecido
        $response['message'] = 'Erro: Nome da sub categoria não fornecido.';
    }
} catch (PDOException $e) {
    $response['message'] = "Erro ao verificar sub categoria: " . $e->getMessage();
}


// Enviar a resposta como JSON
echo json_encode($response);

?>