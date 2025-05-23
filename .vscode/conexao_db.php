<?php

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/bancodedados.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}


?>