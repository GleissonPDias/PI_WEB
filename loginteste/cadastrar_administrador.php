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
    <title>Cadastro de Administrador</title>

</head>
<body>
<h2>Cadastrar Administrador</h2>
<form action="" method="post" enctype="multipart/form-data">
    <!-- Campos do formulário para inserir informações do administrador -->
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>
    <p>
      
 <p>
    <!-- <label for="senha">Senha:</label>
    <input type="number" name="senha" id="senha" required> -->
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>  

    <label for="ativo">Ativo:</label>
    <input type="checkbox" name="ativo" id="ativo" value="1" checked>
    <!-- value="1": Especifica o valor que será enviado quando o checkbox for marcado. Se o usuário marcar o checkbox e enviar o formulário, o valor 1 será enviado como parte dos dados do formulário para o servidor. Se o checkbox não for marcado, o campo ativo não será incluído nos dados do formulário enviado. 
    checked: Este é um atributo booleano que, quando presente, faz com que o checkbox seja exibido como já marcado por padrão quando a página é carregada. -->
    <p>
    
    <p>
    <button type="submit">Cadastrar Administrador</button>
    <!-- Se você omitir o atributo type em um elemento <button> dentro de um formulário, o navegador assumirá por padrão que o botão é do tipo submit. Isso significa que, ao clicar no botão, o formulário ao qual o botão pertence será enviado. Mas é boa prática especificá-lo-->

    <p></p>
    <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
</form>
</body>
</html>