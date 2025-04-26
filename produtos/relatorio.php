<?php



require("conexao_db.php");

try {
    $stmt = $pdo->prepare('SELECT * FROM produto');
    $stmt->execute();
    $relatorio = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro no relatório geral: " . $e->getMessage());
}

try {
    $stmt = $pdo->prepare('SELECT * FROM produto WHERE estoque <= 5 AND estoque > 0');
    $stmt->execute();
    $baixoestoque = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro no relatório de baixo estoque: " . $e->getMessage());
}

try {
    $stmt = $pdo->prepare('SELECT * FROM produto WHERE estoque = 0');
    $stmt->execute();
    $semestoque = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro no relatório de sem estoque: " . $e->getMessage());
}

function gerarTabela($dados, $titulo) {
    $html = "<h2>{$titulo}</h2>";
    $html .= "<table border='1' cellpadding='5' cellspacing='0'>
                <tr>
                    <th>Cod.Produto</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th>Estoque</th>
                </tr>";

    foreach ($dados as $linha) {
        $html .= "<tr>
                    <td>{$linha['id']}</td>
                    <td>{$linha['nome']}</td>
                    <td>{$linha['id_categoria']}</td>
                    <td>{$linha['preco']}</td>
                    <td>{$linha['estoque']}</td>
                  </tr>";
    }

    $html .= "</table><br><br>";
    return $html;
};

// Geração do conteúdo
$saida = '';
$saida .= gerarTabela($relatorio, "Relatorio Geral");
$saida .= gerarTabela($baixoestoque, "Produtos com Baixo Estoque (<= 5)");
$saida .= gerarTabela($semestoque, "Produtos Sem Estoque");

// Cabeçalhos para forçar o download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=relatorio.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Envia o conteúdo diretamente
echo $saida;
exit;
?>


















?>