const exibirprodutos = (prodId, url) => {

    let exibir = document.getElementById(prodId);

    fetch(url)
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
const ativos = () => exibirprodutos("ativos", "ativos.php");
const inativos = () => exibirprodutos("inativos", "inativos.php");

ativos();
inativos();

const produtosnapagina = (url, titulo) => {
    let oncard = document.getElementById('card');
    let subtitle = document.getElementById('subtitle');

    fetch(url)
        .then(response => response.text()) // Corrigido: adicionado os parênteses
        .then(data => {
            oncard.innerHTML = data;
            subtitle.innerHTML = titulo;
        })
        .catch(error => {
            console.error('Erro ao carregar os produtos:', error);
        });
};

const menu = () => produtosnapagina('menu.php', 'MENU');
menu();

const lanches = () => produtosnapagina('lanches.php', 'LANCHES');
const combos = () => produtosnapagina('combos.php', 'COMBOS');
const bebidas = () => produtosnapagina('bebidas.php', 'BEBIDAS');




const categorias = () => {
    let categorias = document.getElementById('categoria');

    fetch('categorias.php')
        .then(response => response.text())
        .then(data => {
            categorias.innerHTML = data;
        })
}
categorias();

const subcategorias = () => {
    let categorias = document.getElementById('subcategoria');
    fetch('subcategorias.php')
        .then(response => response.text())
        .then(data => {
            categorias.innerHTML = data;
        })
}
subcategorias();
const adicionarcategoria = () => {
    const novacategoria = document.getElementById('categoria-adicionar').value.toUpperCase();
    document.getElementById('categoria-adicionar').value = "";

    fetch("cadastrocategoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `novacategoria=${encodeURIComponent(novacategoria)}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            if (data.message) {
                alert(data.message);
            }
            else if (data.success) {
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

const adicionarsubcategoria = () => {
    const novasubcategoria = document.getElementById('subcategoria-adicionar').value.toUpperCase();
    document.getElementById('subcategoria-adicionar').value = "";

    fetch("cadastrosubcategoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `novasubcategoria=${encodeURIComponent(novasubcategoria)}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            if (data.message) {
                alert(data.message);
            }
            else if (data.success) {
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
    const nomeproduto = document.getElementById("nomeproduto").value.toUpperCase();
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


const processarProduto = (inputId, url) => {
    const valor = document.getElementById(inputId).value;
    document.getElementById(inputId).value = "";


    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nomeproduto=${encodeURIComponent(valor)}&id=${encodeURIComponent(valor)}`
    })
        .then(response => response.json())
        .then(data => {
            ativos();
            inativos();
            alert(data.message);
            if (data.success) {
            }
            console.log("Resposta do servidor:", data);
        })
        .catch(error => console.error('Erro:', error));

};

const inativar = () => processarProduto("inativar", "excluirproduto.php");
const ativar = () => processarProduto("ativar", "ativarprodutos.php");


const loceditar = () => {

    let prodedit = document.getElementById('prodedit').value;
    document.getElementById('prodedit').value = '';
    prodloc = document.getElementById('prodlocalizado');

    fetch("localizaredit.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nome=${encodeURIComponent(prodedit)}&id=${encodeURIComponent(prodedit)}`
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição');
            }
            return response.text();
        })
        .then(data => {
            prodlocalizado.innerHTML = data;
        })
        .catch(error => {
            console.error('Erro:', error);
            prodlocalizado.innerHTML = 'Ocorreu um erro ao carregar os produtos.';
        });



}

const editar = () => {
    const id = document.getElementById("idedit").value;
    const nomeproduto = document.getElementById("nomeedit").value.toUpperCase();
    const preco = document.getElementById("precoedit").value;
    const descricao = document.getElementById("descedit").value;
    const estoque = document.getElementById("estoqueedit").value;
    const categoria = document.getElementById("categoriaedit").value;
    const imagem = document.getElementById("imagemedit").value;

    // Limpar os campos de entrada após capturar os dados
    document.getElementById("idedit").value = "";
    document.getElementById("nomeedit").value = "";
    document.getElementById("precoedit").value = "";
    document.getElementById("descedit").value = "";
    document.getElementById("estoqueedit").value = "";
    document.getElementById("categoriaedit").value = "";
    document.getElementById("imagemedit").value = "";

    console.log("Dados enviados:", { nomeproduto, preco, descricao, estoque, categoria, imagem });

    fetch("editar.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"  // O PHP vai receber os dados via $_POST
        },
        body: `nomeproduto=${encodeURIComponent(nomeproduto)}&preco=${encodeURIComponent(preco)}&descricao=${encodeURIComponent(descricao)}&estoque=${encodeURIComponent(estoque)}&categoria=${encodeURIComponent(categoria)}&imagem=${encodeURIComponent(imagem)}&id=${encodeURIComponent(id)}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            if (data.success) {
                alert(data.success);  // Exibe mensagem de sucesso
                exibirprodutos(); // Recarrega os produtos, se necessário
            } else {
                alert(data.error);  // Exibe mensagem de erro
            }
            console.log("Resposta do servidor:", data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    produtosnapagina();
    ativos();
    inativos();
}


