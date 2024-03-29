function limpar_experiencia(id) {
    var empresas = document.getElementsByClassName("experiencia-form");
    for (let i = 0; i < empresas.length; i++) {
        if (empresas[i].id == id) {
            empresas[i].getElementsByTagName("input")[0].value = "";
            empresas[i].getElementsByTagName("input")[1].value = "";
        }
    }

}

function salvar_experiencia() {
    experiencia = [];
    var empresas = document.getElementsByClassName("experiencia-form");
    for (let i = 0; i < empresas.length; i++) {
        if (empresas[i].getElementsByTagName("input")[0].value != "" && empresas[i].getElementsByTagName("input")[1].value != "") {
            experiencia.push([empresas[i].getElementsByTagName("input")[0].value, empresas[i].getElementsByTagName("input")[1].value]);
            document.getElementById("experiencia").value = JSON.stringify(experiencia);
        } else {
            alert("Empresa ou Cargo não informado");
        }
    }
}

function remover_experiencia(id) {
    var empresas = document.getElementsByClassName("experiencia-form");
    for (let i = 0; i < empresas.length; i++) {
        if (empresas[i].id == id) {
            try {
                experiencia.splice(i, 1);
            } catch (e) { }
            empresas[i].remove();
        }
    }
}

function adicionar_experiencia() {
    var tabela = document.getElementById("experiencias");
    var id = tabela.children.length;
    tabela.insertAdjacentHTML ("afterbegin",
        `
    <tr id="` + id + `" class="experiencia-form">
        <th>
            <form method="post">
                <div style="display: flex; flex-direction: column;">
                    <label>Empresa</label>
                    <input type="text" name="empresa" placeholder="Empresa" />
                    <label>Cargo</label>
                    <input type="text" name="cargo" placeholder="Cargo" />
                    <div class="botoes">
                        <input readonly onclick="limpar_experiencia(` + id + `)" class="button action" name="limpar" value="Limpar" />
                        <input readonly onclick="remover_experiencia(` + id + `)" class="button action" name="excluir" value="Excluir" />
                    </div>
            </form>
        </th>
    </tr>
    `);
}

function mascara(cpf) {
    var input = cpf.value;
    if (isNaN(input[input.length - 1])) {
        cpf.value = input.substring(0, input.length - 1);
        return;
    }
    cpf.setAttribute("maxlength", "14");
    if (input.length == 3 || input.length == 7) cpf.value += ".";
    if (input.length == 11) cpf.value += "-";
}

function validar_nome() {
    nome = document.getElementById("nome");
    nome.style.color = 'red';
    if (nome.value.split(" ").length >= 2) {
        nome.style.color = 'green';
    }
}
