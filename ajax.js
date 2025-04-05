/*const produtosnapagina = () => {
    let card_Lanches = document.getElementById('card_Lanches');
    let card_Combos = document.getElementById('card_Combos');
    let card_Bebidas = document.getElementById('card_Bebidas');

    if (figure_id == document.getElementById(`card_Lanches`)) {

        fetch(`produtosnapagina.php?categoriadoproduto=${}`)
            .then(response => response.text())
            .then(data => {
                card_Lanches.innerHTML = data;
            })
            .catch(error => {
                console.error('Erro ao carregar os produtos:', error);
            });
    } else if (figure_id == document.getElementById(`card_Combos`)) {
        fetch("produtosnapagina.php")
            .then(response => response.text())
            .then(data => {
                card_Combos.innerHTML = data;
            })
            .catch(error => {
                console.error('Erro ao carregar os produtos:', error);
            });
    } else {
        fetch("produtosnapagina.php")
            .then(response => response.text())
            .then(data => {
                card_Bebidas.innerHTML = data;
            })
            .catch(error => {
                console.error('Erro ao carregar os produtos:', error);
            });
    }
}

*/

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
    document.getElementById("excluir").value = "";


    fetch("excluirproduto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nomeproduto=${encodeURIComponent(deletar)}&id=${encodeURIComponent(deletar)}`
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
        body: `nomeproduto=${encodeURIComponent(ativar)}&id=${encodeURIComponent(ativar)}`
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



