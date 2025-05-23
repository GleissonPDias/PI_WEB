<?php
header('Content-Type: text/html');
require("../../../conexao_db.php");


try {
    $stmt = $pdo->prepare("SELECT imagem FROM carrossel where id = 1");
    $stmt->execute();
    $firstslide = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}



try {
    $stmt = $pdo->prepare("SELECT * FROM carrossel where id != 1");
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Se houver erro na consulta SQL, exibe a mensagem de erro
    die("Erro na consulta: " . $e->getMessage());
}
    echo '<div class="slides">';
    echo '<input type="radio" name="radio-btn" id="radio1">';
    echo '<input type="radio" name="radio-btn" id="radio2">';
    echo '<input type="radio" name="radio-btn" id="radio3">';
    echo '<input type="radio" name="radio-btn" id="radio4">';

    if ($firstslide) {
        echo '<div class="slide first"><img src="' . $firstslide['imagem'] . '" alt="Imagem do carrossel"></div>';
    } else {
        echo 'Nenhum item encontrado.';
    }

foreach ($dados as $produtos) { 

    echo '<div class="slide"> <img src="' . $produtos['imagem'] . '"> </div>';
}



    echo '<div class="navigation-auto">';
        echo '<div class="auto-btn1"></div>';
        echo '<div class="auto-btn2"></div>';
        echo '<div class="auto-btn3"></div>';
        echo '<div class="auto-btn4"></div>';
    echo '</div>';


    echo '<div class="navigation-manual">';
    echo '<label for="radio1" class="manual-btn"></label>';
    echo '<label for="radio2" class="manual-btn"></label>';
    echo '<label for="radio3" class="manual-btn"></label>';
    echo '<label for="radio4" class="manual-btn"></label>';
    echo '</div>';
    echo '</div>';
?>