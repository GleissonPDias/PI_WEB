<?php

session_start();

require_once('../conexao_db.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    
    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_SENHA,ADM_ATIVO) VALUES (:nome, :senha, :ativo);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT); 

        $stmt->execute();

        $adm_id = $pdo->lastInsertId();

        echo "<p style='color:green;'>Administrador cadastrado com sucesso! ID: " . $adm_id . "</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar Administrador: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.login.css">
    <title>Cadastro de Administrador</title>
    <style>

body {
    background-color: #f0f4f8; 
    display: flex; 
    justify-content: center; 
    align-items: flex-start; 
    padding: 50px 20px; 
    min-height: 100vh; 
}

.container { 
    background-color: #E9efff; 
    padding: 30px;
    border-radius: 10px; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.97); 
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

form {
    display: flex;
    flex-direction: column; 
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



form label[for="ativo"] {
    display: inline-block; /* fique na mesma linha que o checkbox */
    margin-left: 10px; 
    margin-right: 8px; /
    vertical-align: middle;
    color: #666;
}



form br {
    margin-top: 15px; 
    display: block; 
    visibility: hidden; 
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
<body>
    <div class="container">
<h1>Cadastrar Administrador</h1>
<form action="" method="post" enctype="multipart/form-data">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required placeholder="Nome do usuário">
    
      <br>
 
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required placeholder="Digite a senha">  
    <p>
    <label for="ativo">Ativo:</label>
    <input type="checkbox" name="ativo" id="ativo" value="1" checked>
    
    <br>
    <button type="submit">Cadastrar Administrador</button>

    <br>
    <a href="painel_admin.php" >Voltar ao Painel do Administrador</a>
</form>
</div>
</body>
</html>