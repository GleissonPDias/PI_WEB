

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário com Opções</title>
    <link rel="stylesheet" href="style.css">
    <script src="ajax.js" defer></script>
</head>

<body>
    <h2>Cadastro de Produtos</h2>

    <div class="cadcontainer">

        <div class="produtoscadastrados">
            <form id="exibir">

            </form>
            <button type="button" onclick="exibirprodutos()"> atualizar</button>
        </div>

        <div class="adicaoprodutos">

            <form action="">

                <label for="">Nome:</label>
                <input type="text" id="" name="nomeproduto" placeholder="">
                <br>
                <label for="">Categoria</label>
                <select>
                    <option value="a">Option A</option>
                    <option value="b">Option B</option>
                    <option value="c">Option C</option>
                    <option value="d">Option D</option>
                    <option value="e">Option E</option>
                </select>
                <label for="categoria">Adicionar</label>
                <input type="text" id="" name="categoria" placeholder="">
                <button type="button" onclick="adicionarOpcao()">Adicionar nova categoria</button>
                <br>
                <label for="">Sub Categoria</label>
                <select>
                    <option value="a">Option A</option>
                    <option value="b">Option B</option>
                    <option value="c">Option C</option>
                    <option value="d">Option D</option>
                    <option value="e">Option E</option>
                </select>
                <label for="subcategoria">Adicionar</label>
                <input type="text" id="" name="subcategoria" placeholder="">
                <button type="button" onclick="adicionarOpcao()">Adicionar nova sub categoria</button>
                <br>
                <label for="preco">Preço:</label>
                <input type="text" id="" name="preco" placeholder="">
                <br>
                <label for="descricao">Descriçao:</label>
                <textarea id="descricao" name="descricao" rows="4" cols="50"
                    placeholder="Escreva a descrição aqui..."></textarea><br><br>
                <br>
                <label for="estoque">Estoque:</label>
                <input type="number" id="estoque" name="estoque" placeholder="">
                <br>


                <button type="submit">Adicionar novo produto</button>
                <button type="reset">Limpar</button>
            </form>
        </div>
    </div>


</body>

</html>