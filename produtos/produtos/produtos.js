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
            console.error('Erro:', error)
        });

}
const ativos = () => exibirprodutos("ativos", "ativos/ativos.php");
const inativos = () => exibirprodutos("inativos", "inativos/inativos.php");

ativos()
inativos()



const processarProduto = (id, url) => {
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${encodeURIComponent(id)}`

    })
        .then(response => response.json())
        .then(data => {
            ativos();
            inativos();
            alert(data.message);
            console.log("Resposta do servidor:", data);
        })
        .catch(error => console.error('message:', error));
};

const ativar = (id) => processarProduto(id, "ativos/ativarprodutos.php");
const inativar = (id) => processarProduto(id, "inativos/inativarproduto.php");

function mostrar(tipo) {
    document.getElementById('ativos').style.display = 'none';
    document.getElementById('inativos').style.display = 'none';

    document.getElementById(tipo).style.display = 'block';
}

const apagarProduto = (id) => {


    fetch("editar/excluirproduto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${encodeURIComponent(id)}`
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

const loceditar = (id) => {

    prodloc = document.getElementById('prodlocalizado');

    fetch("editar/localizaredit.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("prodlocalizado").style.display = "block";
            prodlocalizado.innerHTML = data;
        })
        .catch(error => {
            console.error('Erro:', error);
            prodlocalizado.innerHTML = 'Ocorreu um erro ao carregar os produtos.';
        });



}
function cancelaredicao() {
    document.getElementById("prodlocalizado").style.display = "none";
}


const editar = (id) => {
    const nomeproduto = document.getElementById("nomeedit").value.toUpperCase();
    const preco = document.getElementById("precoedit").value;
    const descricao = document.getElementById("descedit").value;
    const estoque = document.getElementById("estoqueedit").value;
    const categoria = document.getElementById("categoriaedit").value;
    const subcategoria = document.getElementById("subcategoriaedit").value;
    const imagem = document.getElementById("imagemedit").value;

    // Limpar os campos de entrada após capturar os dados
    document.getElementById("nomeedit").value = "";
    document.getElementById("precoedit").value = "";
    document.getElementById("descedit").value = "";
    document.getElementById("estoqueedit").value = "";
    document.getElementById("categoriaedit").value = "";
    document.getElementById("subcategoriaedit").value = "";
    document.getElementById("imagemedit").value = "";

    console.log("Dados enviados:", { id, nomeproduto, preco, descricao, estoque, categoria, subcategoria, imagem });

    fetch("editar/editar.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${encodeURIComponent(id)}&nomeproduto=${encodeURIComponent(nomeproduto)}&preco=${encodeURIComponent(preco)}&descricao=${encodeURIComponent(descricao)}&estoque=${encodeURIComponent(estoque)}&categoria=${encodeURIComponent(categoria)}&subcategoria=${encodeURIComponent(subcategoria)}&imagem=${encodeURIComponent(imagem)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                ativos();
                inativos();

                document.getElementById("prodlocalizado").style.display = "none";
            } else {
                alert(data.error);
            }
            console.log("Resposta do servidor:", data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}
