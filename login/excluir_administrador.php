<?php
session_start();
require_once('../conexao_db.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: listar_administrador.php');
    exit();
}

try {
        // Excluir administrador
    $stmt = $pdo->prepare("DELETE FROM ADMINISTRADOR WHERE ADM_ID = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: listar_administrador.php');
    exit();
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao excluir administrador: " . $e->getMessage() . "</p>";
}
?>