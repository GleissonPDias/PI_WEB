<?php

// Inicia a sessão para gerenciamento do usuário.
session_start();

// Importa a configuração de conexão com o banco de dados.
require_once('../conexao_db.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

// Bloco que será executado quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do POST.
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0; //esse comando é uma maneira concisa de dizer: "Se o campo ativo do formulário foi marcado, defina $ativo como 1. Caso contrário, defina como 0." Isso é útil para manipular checkboxes em formulários, pois eles só são incluídos nos dados do POST se estiverem marcados. Portanto, essa abordagem permite que você traduza a presença ou ausência do checkbox marcado em um valor booleano representado por 1 ou 0, respectivamente
    
    // Inserindo administrador no banco.
    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_SENHA,ADM_ATIVO) VALUES (:nome, :senha, :ativo);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT); 

        $stmt->execute(); // Adicionado para executar a instrução

        // Pegando o ID do administrador inserido.
        $adm_id = $pdo->lastInsertId();

        echo "<p style='color:green;'>Administrador cadastrado com sucesso! ID: " . $adm_id . "</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar Administrador: " . $e->getMessage() . "</p>";
    }
}
?>

<!-- Início do código HTML -->
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
    <!-- Campos do formulário para inserir informações do administrador -->
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required placeholder="Nome do usuário">
    
      <br>
 
    <!-- <label for="senha">Senha:</label>
    <input type="number" name="senha" id="senha" required> -->
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required placeholder="Digite a senha">  
    <p>
    <label for="ativo">Ativo:</label>
    <input type="checkbox" name="ativo" id="ativo" value="1" checked>
    <!-- value="1": Especifica o valor que será enviado quando o checkbox for marcado. Se o usuário marcar o checkbox e enviar o formulário, o valor 1 será enviado como parte dos dados do formulário para o servidor. Se o checkbox não for marcado, o campo ativo não será incluído nos dados do formulário enviado. 
    checked: Este é um atributo booleano que, quando presente, faz com que o checkbox seja exibido como já marcado por padrão quando a página é carregada. -->
    
    
    <br>
    <button type="submit">Cadastrar Administrador</button>
    <!-- Se você omitir o atributo type em um elemento <button> dentro de um formulário, o navegador assumirá por padrão que o botão é do tipo submit. Isso significa que, ao clicar no botão, o formulário ao qual o botão pertence será enviado. Mas é boa prática especificá-lo-->

    <br>
    <a href="painel_admin.php" >Voltar ao Painel do Administrador</a>
</form>
</div>
</body>
</html>