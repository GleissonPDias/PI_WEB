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
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box; 
}

body.body { 
    background-color: #f0f4f8; 
    display: flex; 
    justify-content: center; 
    align-items: flex-start; 
    padding: 50px 20px; 
    min-height: 100vh;  
}
.card {

    background-color: #E9efff;

    padding: 40px;

    border-radius: 8px;

    width:280px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.97);

}
 
.card, form {
   background-color: #E9efff; 
    padding: 30px;
    border-radius: 10px; 
    width: 100%;
    max-width: 550px; 
}

h1 {
    color: #2c3e50; 
    margin-bottom: 30px;
    text-align: center; 
    font-size: 2.2em; /* Tamanho do título */
    font-weight: 700;

}


form label {
  font-weight: 600; 
    color: #4a6c89; 
    margin-bottom: 5px; 
    margin-top: 15px;
    display: block; 
    text-align: left;
 }

form input[type="text"],
form input[type="password"] {
      width: 100%;
    padding: 12px 4px;
    border: 1px solid #cce7ed;
    border-radius: 8px; 
    font-size: 1.05em;
    color: #333;
    outline: none; 
    transition: border-color 0.2s ease, box-shadow 0.2s ease; /* Transição suave */
    margin-bottom: 0; 
}


form input[type="text"]:focus,
form input[type="password"]:focus {
    border-color: #007bff; /* Borda azul ao focar */
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25); /* Sombra suave ao focar */
}

form p {
   margin-top: 26px;
    margin-bottom: -16px;
    line-height: 1;
}



form label[for="ativo"] {
    display: inline-block; 
    margin-top: 0; 
    margin-left: 20px; 
    margin-right: 8px; 
    vertical-align: middle;
    color: #666;
}


form button[type="submit"] {
     padding: 12px 25px;
    border: none;
    border-radius: 8px;
    font-size: 1.05em;
    cursor: pointer; 
    font-weight: 600;
    margin-top: 30px; 
    background-color: #007bff; 
    color: white;
    display: block; 
    margin-left: auto; 
    margin-right: auto; 
}


form button[type="submit"]:hover {
     background-color:white; 
    transform: translateY(-2px);
    border:2px solid #007bff;
    color:#007bff;
}

    </style>
</head>
<body class="body">
    <div class="card">
<h1>Editar Administrador</h1>
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
</div>
</body>
</html>