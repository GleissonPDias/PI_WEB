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
$novonome = $_POST['novonome'] ?? '';
$response = [];



if($novonome != ''){
    try {
        
        $stmt = $pdo->prepare('UPDATE categoria SET nome = :novonome where nome = :categoria');
        $stmt->execute([
            ':novonome' => $novonome,
            ':categoria' => $categoria
        ]);
        $stmt = $pdo->prepare('UPDATE produto SET id_categoria = :novonome WHERE id_categoria = :categoria');
        $stmt->execute([
            ':novonome' => $novonome,
            ':categoria' => $categoria
        ]);
        
        $response['success'] = true;
        $response['message'] = 'Sub Categoria renomeada com sucesso!';
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['error'] = 'Erro: Campo de renomear vazio.' . $e->getMessage();
    }
}else{
    $response['success'] = false;
    $response['error'] = 'Erro: Campo de renomear vazio.';
}

echo json_encode($response);

?>




