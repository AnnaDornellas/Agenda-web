let lista = localStorage.getItem("minhalista");

const formulario = document.querySelector("form");
const ulPessoas = document.querySelector("ul");

if (lista) {
    lista = JSON.parse(lista);
} else {
    lista = [];
}

listar();

formulario.addEventListener("submit", function (e) {
    e.preventDefault();
    let novaPessoa = new Object();
    novaPessoa.nome = this.nome.value;
    novaPessoa.telefone = this.telefone.value;
    novaPessoa.email = this.email.value;
    const id = this.id.value; 

    if (id !== "" && id >= 0 && id < lista.length) {
        
        lista[id] = novaPessoa;
    } else {
       
        lista.push(novaPessoa);
    }

    this.reset();
    this.id.value = ""; 

    Salvar();

    listar();
});

function listar(filtro = '') {
    ulPessoas.innerHTML = "";
    lista.forEach((item, key) => {
        if (item.nome.toUpperCase().indexOf(filtro.toUpperCase()) >= 0 || filtro === "") {
            let linha = document.createElement('li');
            let s = `<button onClick="excluir(${key})">[Excluir]</button><button onClick="editar(${key})">[Editar]</button>`;
            linha.innerHTML = "Nome: " + item.nome + " Telefone: " + item.telefone + " E-mail: " + item.email + s;
            ulPessoas.appendChild(linha);
        }
    });
}

function excluir(id) {
    formulario.reset();
    lista.splice(id, 1);
    Salvar();
    listar();
}

function editar(id) {
    formulario.id.value = id;
    formulario.nome.value = lista[id].nome;
    formulario.telefone.value = lista[id].telefone;
    formulario.email.value = lista[id].email; 
}

function Salvar() {
    localStorage.setItem("minhalista", JSON.stringify(lista));
}
