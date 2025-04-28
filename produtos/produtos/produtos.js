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

const categoriaspainel = () => {

    let exibir = document.getElementById('categorias');

    fetch('categorias/categorias.php')
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

categoriaspainel()


const subcategoriaspainel = () => {

    let exibir = document.getElementById('subcategorias');

    fetch('categorias/subcategorias.php')
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

subcategoriaspainel()

ativos()



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
    document.getElementById('cadastro').style.display = 'none';
    document.getElementById('categorias').style.display = 'none';
    document.getElementById('subcategorias').style.display = 'none';
    document.getElementById('selecionarcarrossel').style.display = 'none';
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

const locategoria = (nome) => {

    catlocalizada = document.getElementById('categorialocalizada');

    fetch("categorias/localizarcategorias.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nome=${encodeURIComponent(nome)}`
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição');
            }
            return response.text();
        })
        .then(data => {

            categorialocalizada.innerHTML = data;
        })
        .catch(error => {
            console.error('Erro:', error);
            categorialocalizada.innerHTML = 'Ocorreu um erro ao carregar os produtos.';
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

    fetch("cadastro/cadastroproduto.php", {
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

};

const categorias = () => {
    let categorias = document.getElementById('categoria');
    let categoriasfiltro = document.getElementById('categoriaFiltro');


    fetch('cadastro/categorias.php')
        .then(response => response.text())
        .then(data => {
            if (categorias) categorias.innerHTML = data;
            if (categoriasfiltro) categoriasfiltro.innerHTML = data;
            //if (subcategoriaslocalizadas) subcategoriaslocalizadas.innerHTML = data;
            // se tiver sem o if o codigo buga pois tenta localizar o categorias que nao existe no menu.html
            //Com esse if, seu script funciona tanto no cadastro.html quanto no menu.html, sem precisar duplicar ou mudar nada.
        })
}
categorias();


const subcategorias = () => {
    let subcategorias = document.getElementById('subcategoria');
    let subcategoriasfiltro = document.getElementById('subcategoriaFiltro');
    let subcategoriaslocalizadas = document.getElementById('subcategoriaslocalizadas')
    fetch('cadastro/subcategorias.php')
        .then(response => response.text())
        .then(data => {
            if (subcategorias) subcategorias.innerHTML = data;
            if (subcategoriasfiltro) subcategoriasfiltro.innerHTML = data;
            //if (subcategoriaslocalizadas) subcategoriaslocalizadas.innerHTML = data;
        })
}
subcategorias();

const adicionarcategoria = () => {
    const novacategoria = document.getElementById('categoria-adicionar').value.toUpperCase();


    document.getElementById('categoria-adicionar').value = "";




    fetch("cadastro/cadastrocategoria.php", {
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
                categorias();
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

    fetch("cadastro/cadastrosubcategoria.php", {
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
                subcategorias();
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


const apagarCategorias = (nome, url) => {
    console.log("Nome enviado para apagar:", nome); // Adicione aqui para testar
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `categoria=${encodeURIComponent(nome)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                categorias();
                subcategorias();
                categoriaspainel();
            } else {
                alert(data.error);
            }
        })
        .catch(message => {
            console.error('Erro:', message);
        });
}

const apagarCategoria = (nome) => apagarCategorias(nome, 'categorias/excluircategoria.php');
const apagarSubCategoria = (nome) => apagarCategorias(nome, 'categorias/excluirsubcategoria.php');

function editarCategoria(id, nomeAtual) {
    const novoNome = prompt(`Renomear a categoria "${nomeAtual}" para:`);

    if (novoNome && novoNome.trim() !== "") {
        fetch('categorias/renomearcategoria.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `categoria=${encodeURIComponent(id)}&novonome=${encodeURIComponent(novoNome.toUpperCase())}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    categoriaspainel()
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
}


function editarSubCategoria(id, nomeAtual) {
    const novoNome = prompt(`Renomear a categoria "${nomeAtual}" para:`);

    if (novoNome && novoNome.trim() !== "") {
        fetch('categorias/renomearsubcategoria.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `categoria=${encodeURIComponent(id)}&novonome=${encodeURIComponent(novoNome.toUpperCase())}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    subcategoriaspainel()
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
}


const imagemcarrossel = () => {
    // Pega o container onde o conteúdo será inserido
    let container = document.getElementById('selecionarcarrossel');

    fetch('carrossel/selecionarcarrossel.php')
        .then(response => response.text())
        .then(data => {
            container.innerHTML = data;
        });
};

// Só chama imagemcarrossel depois do DOM estar carregado
document.addEventListener('DOMContentLoaded', () => {
    imagemcarrossel();
});

const addimagemcarrossel = () => {
    // Atenção: agora temos que pegar o <select> dentro do container que foi carregado
    const select = document.querySelector('#selecionarcarrossel select'); // pega o <select> dentro do #selecionarcarrossel
    const imagem = document.getElementById('imagemcarrossel').value;

    if (!select) {
        console.error('Erro: select não encontrado dentro de #selecionarcarrossel');
        return;
    }

    const id = select.value;

    console.log(imagem);
    console.log(id);

    fetch('carrossel/addimagemcarrossel.php', {
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
                console.log(id);
            } else {
                alert(data.message);
            }
        })
        .catch(message => {
            console.error('Erro:', message);
        });
};



const produtosnapagina = () => {
    let oncard = document.getElementById('card');

    fetch('pagina/produtosnapagina.php')
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


    fetch('carrossel/carrossel.php')
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


function aplicarFiltros() {
    let categoria = document.getElementById('categoriaFiltro').value;
    let subcategoria = document.getElementById('subcategoriaFiltro').value;
    let preco = document.getElementById('ordemPreco').value;
    let nome = document.getElementById('ordemNome').value;
    let pesquisa = document.getElementById('pesquisaNome').value;

    fetch('pagina/filtroprodutos.php', {
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
