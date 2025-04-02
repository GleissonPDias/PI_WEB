const produtosnapagina = () => {
    let oncard = document.getElementById('card');

    fetch("produtosnapagina.php")
        .then(response => response.text()) // Corrigido: adicionado os parênteses
        .then(data => {
            oncard.innerHTML = data;
        })
        .catch(error => {
            console.error('Erro ao carregar os produtos:', error);
        });
};

produtosnapagina();

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
    const imagem = document.getElementById("imagem").value;

    document.getElementById("nomeproduto").value = "";
    document.getElementById("preco").value = "";
    document.getElementById("descricao").value = "";
    document.getElementById("estoque").value = "";
    document.getElementById("categoria").value = "";
    document.getElementById("subcategoria").value = "";
    document.getElementById("imagem").value = "";

    console.log("Dados enviados:", { nomeproduto, preco, descricao, estoque, categoria, subcategoria, imagem });

    fetch("cadastroproduto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nomeproduto=${encodeURIComponent(nomeproduto)}&preco=${encodeURIComponent(preco)}&descricao=${encodeURIComponent(descricao)}&estoque=${encodeURIComponent(estoque)}&categoria=${encodeURIComponent(categoria)}&subcategoria=${encodeURIComponent(subcategoria)}&imagem=${encodeURIComponent(imagem)}}`
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
    produtosnapagina();
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



const inativos = () => {
    let exibir = document.getElementById('inativos');

    fetch('inativos.php')
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

inativos();

const excluir = () => {

    let deletar = document.getElementById("excluir").value;


    fetch("excluirproduto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nomeproduto=${encodeURIComponent(deletar)}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            if (data.success) {
                alert(data.message);  // Exibe mensagem de sucesso
                exibirprodutos();
                inativos();
            } else {
                alert(data.message);  // Exibe mensagem de erro
            }
            console.log("Resposta do servidor:", data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });
};

const ativarproduto = () => {

    let ativar = document.getElementById("ativarproduto").value;
    document.getElementById("ativarproduto").value = "";


    fetch("ativarprodutos.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nomeproduto=${encodeURIComponent(ativar)}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            if (data.success) {
                alert(data.message);  // Exibe mensagem de sucesso
                exibirprodutos();
                inativos();
            } else {
                alert(data.message);  // Exibe mensagem de erro
            }
            console.log("Resposta do servidor:", data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });
};



