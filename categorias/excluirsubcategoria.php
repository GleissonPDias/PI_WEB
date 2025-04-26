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
        
    $stmt = $pdo->prepare('DELETE FROM sub_categoria where nome = :categoria');
    $stmt->execute([
        ':categoria' => $categoria
    ]);
    
    $response['success'] = true;
    $response['message'] = 'Sub Categoria apagada com sucesso!';
} catch (PDOException $e) {
    $response['success'] = false;
    $response['error'] = 'Erro: Ao apagar Sub Categoria.' . $e->getMessage();
    }


echo json_encode($response);

?>




