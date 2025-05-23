<?php
header('Content-Type: application/json');
require("../../../conexao_db.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido.']);
    exit;
}

$id = $_POST['categoria'] ?? '';
$novonome = $_POST['novonome'] ?? '';

if (empty($id) || empty($novonome)) {
    echo json_encode(['success' => false, 'message' => 'Campos obrigatórios.']);
    exit;
}

try {
    $stmt = $pdo->prepare('UPDATE sub_categoria SET nome = :novonome WHERE id = :id');
    $stmt->execute([
        ':novonome' => $novonome,
        ':id' => $id
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Sub Categoria renomeada com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhuma alteração feita.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco: ' . $e->getMessage()]);
}
?>
