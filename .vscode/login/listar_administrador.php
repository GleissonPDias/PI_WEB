<?php

//Nesse arquivo, que pode ser chamado na página painel_administrador, primeiro selecionamos através de um script php todos os administradores ativos do banco de dados. Armazenamos esse resultado na variável $administradores
//A seguir, através de uma tabela no html, puxamos esses dados selecionados (através de um foreach, usando a variável $administradores e uma variável $adm, criada no foreach) e os apresentamos.
//Também criamos dois links em cada linha da tabela para editar (quando clicado, direciona o usuário para a página editar_administrador.php, passando o ID do administrador como um parâmetro GET na URL) ou excluir o administrador (quando clicado, chama a function confirmDeletion(), que cria uma janela que é apresentada ao usuário para confirmar a exclusão ou não do administrador)

session_start();

require_once('conexao_db.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:admin.php");
    exit();
}
$administradores = []; // Inicializa como array vazio

try {
    /*sem usar declarações preparadas (Executa a consulta diretamente):
     $result = $pdo->query("SELECT * FROM ADMINISTRADOR");
    // Busca todos os registros retornados
    $administradores = $result->fetchAll(PDO::FETCH_ASSOC); */

    //Usando declarações preparadas (recomendado):
    $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR"); //vai buscar todas as colunas da tabela ADMINISTRADOR
    $stmt->execute();  //***vide explicações sobre a dinâmica desses comandos no final do arquivo
    $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch = recuperar, buscar
    
    /*Para efeitos de depuração, se quisesse ver a variável $administradores, poderia mandar escrevê-la:
    echo '<pre>';
    print_r($administradores);
    echo '</pre>';  */

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar administradores: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listar Administradores</title>
    <style> /* Início do bloco de estilos CSS */
    /* Seleciona o elemento <body> de toda a página */
    body { 
        /* Define a família de fontes: Arial, com fallback sans-serif */
        font-family: 'Arial', sans-serif; 
    } /* Fim das regras para <body> */

    /* Seleciona todas as tabelas */
    table { 
        /* Faz a tabela ocupar 100% da largura disponível */
        width: 100%; 
        /* Une as bordas das células, removendo espaços extras */
        border-collapse: collapse; 
        /* Adiciona 20px de espaço acima da tabela */
        margin-top: 20px; 
    } /* Fim das regras para <table> */

    /* Seleciona células de cabeçalho (<th>) e de dados (<td>) */
    th, td { 
        /* Aplica 10px de espaçamento interno em todas as direções */
        padding: 10px; 
        /* Adiciona borda sólida de 1px com cor cinza claro (#ddd) */
        border: 1px solid #ddd; 
        /* Alinha o conteúdo textual à esquerda */
        text-align: left; 
    } /* Fim das regras para <th> e <td> */

    /* Seleciona apenas as células de cabeçalho */
    th { 
        /* Define cor de fundo verde */
        background-color: #4CAF50; 
        /* Define cor do texto como branco */
        color: white; 
    } /* Fim das regras para <th> */

    /* Seleciona cada linha (<tr>) quando o mouse passa por cima */
    tr:hover { 
        /* Altera o fundo para cinza claro em hover */
        background-color: #f1f1f1; 
    } /* Fim das regras para tr:hover */

    /* Seleciona elementos com a classe .action-btn */
    .action-btn { 
        /* Define fundo verde */
        background-color: #4CAF50; 
        /* Define texto em branco */
        color: white; 
        /* Aplica espaçamento interno: 5px vertical e 10px horizontal */
        padding: 5px 10px; 
        /* Remove qualquer borda padrão */
        border: none; 
        /* Remove sublinhado de links */
        text-decoration: none; 
        /* Faz o elemento se comportar como bloco inline */
        display: inline-block; 
    } /* Fim das regras para .action-btn */

    /* Seleciona .action-btn quando o mouse passa por cima */
    .action-btn:hover { 
        /* Escurece ligeiramente o fundo no hover */
        background-color: #45a049; 
    } /* Fim das regras para .action-btn:hover */

    /* Seleciona elementos com a classe .delete-btn */
    .delete-btn { 
        /* Define fundo vermelho */
        background-color: #f44336; 
    } /* Fim das regras para .delete-btn */

    /* Seleciona .delete-btn quando o mouse passa por cima */
    .delete-btn:hover { 
        /* Escurece o fundo no hover para indicar ação crítica */
        background-color: #da190b; 
    } /* Fim das regras para .delete-btn:hover */
</style> <!-- Fim do bloco de estilos CSS -->


<script>
function confirmDeletion() {
    return confirm('Tem certeza que deseja deletar este administrador?'); //o método confirm() é um método embutido (nativo) do JavaScript. Ele exibe uma caixa de diálogo com uma mensagem e dois botões: "OK" e "Cancelar". Este método é comumente usado para solicitar uma confirmação do usuário antes de realizar uma ação importante, como deletar um item. confirm(...) mostra uma janela modal com “OK” e “Cancelar”. Se o usuário clicar em OK, confirm(...) retorna true → o link é seguido. Se clicar em Cancelar, retorna false → nada acontece.
}
</script>

</head>
<body>
<h2>Administradores Cadastrados</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Senha</th>
        <th>Ativo</th>
        <th>Ações</th>
        <!-- <th>Imagem</th> -->
    </tr>
    <?php foreach($administradores as $adm): ?>
    <tr>
        <td><?php echo $adm['ADM_ID']; ?></td>
        <td><?php echo $adm['ADM_NOME']; ?></td>
        <td><?php echo $adm['ADM_EMAIL']; ?></td>
        <td><?php echo $adm['ADM_SENHA']; ?></td>
        <td><?php echo ($adm['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
        
        <td>
            <a href="editar_administrador.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn">Editar</a>
            <!-- A linha de código HTML acima, cria um link que, quando clicado, direciona o usuário para a página editar_administrador.php, passando o ID do administrador como um parâmetro GET na URL. Além disso, o link é estilizado com uma classe CSS chamada action-btn. 
            ?id=< ?php echo $adm['ADM_ID']; ?>: Esta parte é um parâmetro de query na URL. Após o nome do arquivo PHP (editar_administrador.php), o ? inicia a string de query. id= define uma variável de query chamada id, cujo valor é definido pelo trecho PHP < ?php echo $adm['ADM_ID']; ?>. Este código PHP insere dinamicamente o ID do administrador no link, pegando o valor da chave ADM_ID do array $adm. Isso significa que, para cada administrador listado, será gerado um link único que inclui seu respectivo ID como parte da URL. Essa técnica é comumente usada para passar informações entre páginas via URL
            
            Como funciona o <a href="…?id=< ?php echo $adm['ADM_ID']; ?>">
            O browser renderiza esse trecho em HTML puro. Por exemplo, para o administrador de ID 2:

            <a href="editar_administrador.php?id=2" class="action-btn">Editar</a>
            Quando o usuário clica, o navegador faz uma requisição GET para
            editar_administrador.php?id=2.

            Em editar_administrador.php, você acessa $_GET['id'] (aqui, o valor 2) e pode usá-lo para carregar o registro correto do banco de dados ou apenas confirmar que recebeu o parâmetro.

            Dessa forma, usando query strings (?chave=valor), você passa informações entre páginas sem formulários, só com links dinâmicos.
                -->

            <a href="excluir_administrador.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn delete-btn" onclick="return confirmDeletion();">Excluir</a>
            <!-- O atributo onclick em um elemento HTML define um handler (ou “ouvinte”) de evento JavaScript que será executado quando o usuário clicar naquele elemento. Antes de seguir a URL (excluir_administrador.php?id=...), o navegador vai executar a função JavaScript confirmDeletion().O return é fundamental. Se confirmDeletion() retornar true, o clique prossegue normalmente e o navegador carrega a página apontada em href.Se retornar false, a ação padrão (navegar para href) é cancelada.-->
        </td>
</tr>

    <?php endforeach; ?>
</table>
    <p></p>
    <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
</body>
</html>