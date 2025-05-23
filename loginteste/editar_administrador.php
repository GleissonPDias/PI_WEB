<?php

//Nesse arquivo, primeiro recuperamos os dados do administrador que queremos editar (que foram enviados da página listar_administrador.php ao clicar o link editar). 
//Para saber qual administrador estamos considerando, recuperamos via superglobal $_GET o id do administrador em questão
//Feito isso, vamos para a página html que está no final desse arquivo e apresentamos os dados num formulário html, que nos permite editar os dados necessários.
//Feito isso, temos no html, no final da página, um botão que permite enviar os dados para serem atualizados no BD via script php que está no meio desse arquivo aqui
//Aí, nesse  script php, recebemos os dados que foram atualizados no formulário e enviados via método post para esse arquivo mesmo e atualizamos os dados no BD
//
session_start();

require_once('../conexao_db.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

//1. Recuperando o id do administrador que foi passado na página listar_administrador ao clicar o link de editar______________________________________________________
$adm_id = $_GET['id']; //busca o id na linha <a href="editar_administrador.php?id=<?php echo $adm['ADM_ID']; ? >" class="action-btn">Editar</a>         definido em ?id=<?php echo $adm['ADM_ID']; ? >   que está no arquivo listar_administrador.php

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
<!-- Atributo enctype="multipart/form-data" em um formulário HTML é usado para especificar como os dados do formulário devem ser codificados ao serem enviados para o servidor.
Quando um formulário contém um campo de upload de arquivos (usando <input type="file">), o enctype="multipart/form-data" é obrigatório. Ele permite que o navegador envie os dados do formulário, incluindo arquivos, de maneira apropriada ao servidor.
Aqui está o que acontece quando você usa o enctype="multipart/form-data":
-Envio de Arquivos: O método padrão de envio de formulários (application/x-www-form-urlencoded) não é adequado para o envio de arquivos, pois ele codifica os dados em um formato de URL, o que não suporta a transmissão de arquivos binários. O multipart/form-data permite que arquivos sejam enviados corretamente, dividindo os dados em partes que incluem o conteúdo do arquivo.
-Segmentação de Campos: Os dados do formulário são divididos em várias partes, e cada campo é tratado como uma parte separada da solicitação HTTP, permitindo que tanto dados de texto quanto arquivos sejam enviados no mesmo formulário. -->
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
    <!-- 
    value="1"   Define o que será enviado ao servidor, se o checkbox estiver marcado
    checked     Controla o estado inicial do checkbox quando a página carrega (se vai aparecer marcado ou não). Sem ele, mesmo que value="1", o checkbox inicia sempre desmarcado. --> 


    <p>
    <button type="submit">Atualizar Administrador</button>
</form>

<p></p>
    <a href="listar_administrador.php">Voltar à Lista de Administradores</a>
</body>
</html>