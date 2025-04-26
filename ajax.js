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

const produtosnapagina = () => {
    let oncard = document.getElementById('card');

    fetch('produtosnapagina.php')
        .then(response => response.text()) // Corrigido: adicionado os parênteses
        .then(data => {
            oncard.innerHTML = data;

        })
        .catch(error => {
            console.error('Erro ao carregar os produtos:', error);
        });
};



const carrosselnapagina = () => {
    let oncarrossel = document.getElementById('slider');


    fetch('carrossel.php')
        .then(response => response.text()) // Corrigido: adicionado os parênteses
        .then(data => {
            oncarrossel.innerHTML = data;

        })
        .catch(error => {
            console.error('Erro ao carregar os produtos:', error);
        });
};

produtosnapagina();
carrosselnapagina();




const categorias = () => {
    let categorias = document.getElementById('categoria');
    let categoriasfiltro = document.getElementById('categoriaFiltro');
    let categoriaslocalizadas = document.getElementById('categoriaslocalizadas')

    fetch('categorias.php')
        .then(response => response.text())
        .then(data => {
            if (categorias) categorias.innerHTML = data;
            if (categoriasfiltro) categoriasfiltro.innerHTML = data;
            if (categoriaslocalizadas) categoriaslocalizadas.innerHTML = data;
            // se tiver sem o if o codigo buga pois tenta localizar o categorias que nao existe no menu.html
            //Com esse if, seu script funciona tanto no cadastro.html quanto no menu.html, sem precisar duplicar ou mudar nada.
        })
}
categorias();


const subcategorias = () => {
    let subcategorias = document.getElementById('subcategoria');
    let subcategoriasfiltro = document.getElementById('subcategoriaFiltro');
    let subcategoriaslocalizadas = document.getElementById('subcategoriaslocalizadas')
    fetch('subcategorias.php')
        .then(response => response.text())
        .then(data => {
            if (subcategorias) subcategorias.innerHTML = data;
            if (subcategoriasfiltro) subcategoriasfiltro.innerHTML = data;
            if (subcategoriaslocalizadas) subcategoriaslocalizadas.innerHTML = data;
        })
}
subcategorias();

const imagemcarrossel = () => {
    let imgcarrossel = document.getElementById('selecionarcarrossel');


    fetch('selecionarcarrossel.php')
        .then(response => response.text())
        .then(data => {
            imgcarrossel.innerHTML = data;
        })
}
imagemcarrossel();

const addimagemcarrossel = () => {
    const imagem = document.getElementById('imagemcarrossel').value;
    const id = document.getElementById('selecionarcarrossel').value;

    fetch('addimagemcarrossel.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `imagem=${encodeURIComponent(imagem)}&id=${id}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(message => {
            console.error('Erro:', message);
        });
};




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
    const id_categoria = document.getElementById('categoria').value.toUpperCase();
    document.getElementById('subcategoria-adicionar').value = "";
    document.getElementById('categoria').value = "";

    fetch("cadastrosubcategoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `novasubcategoria=${encodeURIComponent(novasubcategoria)}&id_categoria=${encodeURIComponent(id_categoria)}`
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

    fetch("/PI/produtos/cadastro/cadastroproduto.php", {
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
        body: `id=${encodeURIComponent(valor)}`
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

const inativar = () => processarProduto("produtos.html/inativar", "inativos/inativarproduto.php");
const ativar = () => processarProduto("produtos.html/ativar", "ativos/ativarprodutos.php");

const apagarProduto = () => {
    const produto = document.getElementById('apagarProdutos').value;
    document.getElementById('apagarProdutos').value = "";


    fetch("excluirproduto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nomeproduto=${encodeURIComponent(produto)}&id=${encodeURIComponent(produto)}`
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
    const subcategoria = document.getElementById("subcategoriaedit").value;
    const imagem = document.getElementById("imagemedit").value;

    // Limpar os campos de entrada após capturar os dados
    document.getElementById("idedit").value = "";
    document.getElementById("nomeedit").value = "";
    document.getElementById("precoedit").value = "";
    document.getElementById("descedit").value = "";
    document.getElementById("estoqueedit").value = "";
    document.getElementById("categoriaedit").value = "";
    document.getElementById("subcategoriaedit").value = "";
    document.getElementById("imagemedit").value = "";

    console.log("Dados enviados:", { nomeproduto, preco, descricao, estoque, categoria, subcategoria, imagem });

    fetch("editar.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"  // O PHP vai receber os dados via $_POST
        },
        body: `nomeproduto=${encodeURIComponent(nomeproduto)}&preco=${encodeURIComponent(preco)}&descricao=${encodeURIComponent(descricao)}&estoque=${encodeURIComponent(estoque)}&categoria=${encodeURIComponent(categoria)}&subcategoria=${encodeURIComponent(subcategoria)}&imagem=${encodeURIComponent(imagem)}&id=${encodeURIComponent(id)}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            if (data.success) {
                alert(data.success);  // Exibe mensagem de sucesso
                exibirprodutos(); // Recarrega os produtos, se necessário
                produtosnapagina();
                ativos();
                inativos();
            } else {
                alert(data.error);  // Exibe mensagem de erro
            }
            console.log("Resposta do servidor:", data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}

function aplicarFiltros() {
    let categoria = document.getElementById('categoriaFiltro').value;
    let subcategoria = document.getElementById('subcategoriaFiltro').value;
    let preco = document.getElementById('ordemPreco').value;
    let nome = document.getElementById('ordemNome').value;
    let pesquisa = document.getElementById('pesquisaNome').value;

    fetch('filtroprodutos.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `categoria=${encodeURIComponent(categoria)}&subcategoria=${encodeURIComponent(subcategoria)}&preco=${encodeURIComponent(preco)}&nome=${encodeURIComponent(nome)}&pesquisa=${encodeURIComponent(pesquisa)}`
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('card').innerHTML = data;
        })
        .catch(error => console.error('Erro ao filtrar:', error));
}

const renomearCategorias = (nome, novonome, api) => {
    const valorCategoria = document.getElementById(nome).value;
    const valorNovoNome = document.getElementById(novonome).value.toUpperCase();

    fetch(api, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `categoria=${encodeURIComponent(valorCategoria)}&novonome=${encodeURIComponent(valorNovoNome)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                exibirprodutos();
                categorias();
                subcategorias();
            } else {
                alert(data.error);
            }
        })
        .catch(message => {
            console.error('Erro:', message);
        });
}

const renomearCategoria = () => renomearCategorias("categoriaslocalizadas", "renomearCategoria", "renomearcategoria.php");
const renomearSubCategoria = () => renomearCategorias("subcategoriaslocalizadas", "renomearSubCategoria", "renomearsubcategoria.php");


const apagarCategorias = (categoria, url) => {
    const categoriaSelecionada = document.getElementById(categoria).value;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `categoria=${encodeURIComponent(categoriaSelecionada)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                exibirprodutos();
                categorias();
                subcategorias();
            } else {
                alert(data.error);
            }
        })
        .catch(message => {
            console.error('Erro:', message);
        });
}

const apagarCategoria = () => apagarCategorias('categoriaslocalizadas', 'excluircategoria.php');
const apagarSubCategoria = () => apagarCategorias('subcategoriaslocalizadas', 'excluirsubcategoria.php');





const addusuario = () => {
    const email = document.getElementById("email").value.toUpperCase();
    const nome = document.getElementById("nome").value.toUpperCase();
    const telefone = document.getElementById("telefone").value;
    const senha = document.getElementById("senha").value;
    const confirmar_senha = document.getElementById("confirmar_senha").value;

    document.getElementById("email").value = "";
    document.getElementById("nome").value = "";
    document.getElementById("telefone").value = "";
    document.getElementById("senha").value = "";
    document.getElementById("confirmar_senha").value = "";


    fetch("cadastrousuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `email=${encodeURIComponent(email)}&nome=${encodeURIComponent(nome)}&telefone=${encodeURIComponent(telefone)}&senha=${encodeURIComponent(senha)}}`
    })
        .then(response => response.json())  // Processa a resposta como JSON
        .then(data => {
            console.log("Resposta do servidor:", data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });

};