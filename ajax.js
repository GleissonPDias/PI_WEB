const adicionarcategoria = () => {
    const novacategoria = document.getElementById('categoria-adicionar').value;

    fetch("cadastrocategoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `novacategoria=${encodeURIComponent(novacategoria)}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            if (data.success) {
                alert(data.message);  // Exibe mensagem de sucesso
            } else {
                alert(data.message);  // Exibe mensagem de erro
            }
            console.log("Resposta do servidor:", data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });
};



const addproduto = () => {
    const nomeproduto = document.getElementById("nomeproduto").value;
    const preco = document.getElementById("preco").value;
    const descricao = document.getElementById("descricao").value;
    const estoque = document.getElementById("estoque").value;
    const categoria = document.getElementById("categoria").value;
    const subcategoria = document.getElementById("subcategoria").value;

    document.getElementById("nomeproduto").value = "";
    document.getElementById("preco").value = "";
    document.getElementById("descricao").value = "";
    document.getElementById("estoque").value = "";
    document.getElementById("categoria").value = "";
    document.getElementById("subcategoria").value = "";

    console.log("Dados enviados:", { nomeproduto, preco, descricao, estoque, categoria, subcategoria });

    fetch("cadastroproduto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nomeproduto=${encodeURIComponent(nomeproduto)}&preco=${encodeURIComponent(preco)}&descricao=${encodeURIComponent(descricao)}&estoque=${encodeURIComponent(estoque)}&categoria=${encodeURIComponent(categoria)}&subcategoria=${encodeURIComponent(subcategoria)}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            if (data.success) {
                alert(data.message);  // Exibe mensagem de sucesso
                exibirprodutos();
            } else {
                alert(data.message);  // Exibe mensagem de erro
            }
            console.log("Resposta do servidor:", data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });
};

const exibirprodutos = () => {
    let exibir = document.getElementById('exibir');

    fetch('produtoscadastrados.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição');
            }
            return response.text();
        })
        .then(data => {
            exibir.innerHTML = data;
        })
        .catch(error => {
            console.error('Erro:', error);
            exibir.innerHTML = 'Ocorreu um erro ao carregar os produtos.';
        });


}

exibirprodutos();

