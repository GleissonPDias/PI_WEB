<?php
header('Content-Type: application/json');
require("conexao_db.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método de requisição inválido. Utilize POST.'
    ]);
    exit; // Encerra a execução do script
}

$categoria = $_POST['categoria'] ?? '';
$response = [];


try {
        
    $stmt = $pdo->prepare('DELETE FROM categoria where nome = :categoria');
    $stmt->execute([
        ':categoria' => $categoria
    ]);
    
    $response['success'] = true;
    $response['message'] = 'Categoria apagada com sucesso!';
} catch (PDOException $e) {
    $response['success'] = false;
    $response['error'] = 'Erro: Ao apagar categoria.' . $e->getMessage();
    }


echo json_encode($response);

?>




