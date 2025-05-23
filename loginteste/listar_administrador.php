<?php

session_start();

require_once('../conexao_db.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
$administradores = []; // Inicializa como array vazio

try {
    $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR");
    $stmt->execute();
    $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar administradores: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listar Administradores</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .action-btn {
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        border: none;
        text-decoration: none;
        display: inline-block;
        margin-right: 5px;
    }

    .action-btn:hover {
        background-color: #45a049;
    }

    .delete-btn {
        background-color: #f44336;
    }

    .delete-btn:hover {
        background-color: #da190b;
    }

    /* Estilo para o botão de adicionar */
    .add-btn {
        background-color: #2196F3;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
    }

    .add-btn:hover {
        background-color: #0b7dda;
    }
</style>

<script>
function confirmDeletion() {
    return confirm('Tem certeza que deseja deletar este administrador?');
}
</script>

</head>
<body>
<h2>Administradores Cadastrados</h2>
<!-- Botão para adicionar novo administrador -->
<a href="cadastrar_administrador.php" class="add-btn">Adicionar Novo Administrador</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Senha</th>
        <th>Ativo</th>
        <th>Ações</th>
    </tr>
    <?php foreach($administradores as $adm): ?>
    <tr>
        <td><?php echo $adm['ADM_ID']; ?></td>
        <td><?php echo $adm['ADM_NOME']; ?></td>
        <td><?php echo $adm['ADM_SENHA']; ?></td>
        <td><?php echo ($adm['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
        
        <td>
            <a href="editar_administrador.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn">Editar</a>
            <a href="excluir_administrador.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn delete-btn" onclick="return confirmDeletion();">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
    <p></p>
    <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
</body>
</html>