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

};

const categorias = () => {
    let categorias = document.getElementById('categoria');


    fetch('categorias.php')
        .then(response => response.text())
        .then(data => {
            if (categorias) categorias.innerHTML = data;
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
