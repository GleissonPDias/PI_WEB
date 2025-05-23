<?php

session_start();

require_once('../conexao_db.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

//1. Recuperando o id do administrador que foi passado na página listar_administrador ao clicar o link de editar______________________________________________________
$adm_id = $_GET['id'];

// Busca as informações do administrador no BD
$stmt_adm = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :adm_id");
$stmt_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_adm->execute();
$adm = $stmt_adm->fetch(PDO::FETCH_ASSOC);

//____________________________________________________________________


//3.Recuperando os dados que foram atualizados no formulário abaixo (html) via método post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    // Atualizando as informações do administrador no BD
    try {
        $stmt_update_adm = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_SENHA = :senha,  ADM_ATIVO = :ativo  WHERE ADM_ID = :adm_id");
        $stmt_update_adm->bindParam(':nome', $nome);
        $stmt_update_adm->bindParam(':senha', $senha);
        $stmt_update_adm->bindParam(':ativo', $ativo);
        $stmt_update_adm->bindParam(':adm_id' ,$adm_id);
        $stmt_update_adm->execute();

        echo "<p style='color:green;'>Administrador atualizado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar administrador: " . $e->getMessage() . "</p>";
    }
}
?>


<!-- 2.Recuperando os dados do administrador em um formulário que nos permite editá-los e no final desse html enviando os dados para serem recuperados no item 3 acima -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
</head>
<body>
<h2>Editar Administrador</h2>
<form action="" method="post" enctype="multipart/form-data"> 

    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?= $adm['ADM_NOME'] ?>" required>
    <p>
    <!-- Na linha acima, o short echo tag (< ?=)  é exatamente equivalente a: (< ?php) -->
    <label for="senha">Senha:</label>
    <input type="text" name="senha" id="senha" value=" <?= $adm['ADM_SENHA'] ?>" required>
    <p>
    <p>
    <label for="ativo">Ativo:</label>
    <input type="checkbox" name="ativo" id="ativo" value="1" <?= $adm['ADM_ATIVO'] ? 'checked' : '' ?>>
    <p>

    <p>
    <button type="submit">Atualizar Administrador</button>
</form>

<p></p>
    <a href="listar_administrador.php">Voltar à Lista de Administradores</a>
</body>
</html>