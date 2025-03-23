var menuItem = document.querySelectorAll('.item-menu')

function selectLink() {
    menuItem.forEach((item) =>
        item.classList.remove('ativo')
    )
    this.classList.add('ativo')
}

menuItem.forEach((item) =>
    item.addEventListener('click', selectLink)
)


//Expandir o menu

var btnExp = document.querySelector('#btn-exp')
var menuSide = document.querySelector('.menu-lateral')


btnExp.addEventListener('click', function () {
    menuSide.classList.toggle('expandir')
})

let count = 1;
document.getElementById("radio1").checked = true;

setInterval(function () {
    nextImage();
}, 5000)


function nextImage() {
    count++;
    if (count > 4) {
        count = 1;
    }

    document.getElementById("radio" + count).checked = true;

}




// formulario


function adicionarOpcao() {
    var novoValor = document.getElementById("novaOpcao").value;
    if (novoValor !== "") {
        // Adicionar nova opção à lista (pode ser armazenado no banco)
        var select = document.getElementById("opcoesSelect");
        var novaOpcao = document.createElement("option");
        novaOpcao.value = novoValor;
        novaOpcao.text = novoValor;
        select.appendChild(novaOpcao);

        // Limpar o campo de entrada
        document.getElementById("novaOpcao").value = "";
    }
}