
function limpar_experiencia(id) {
    var empresas = document.getElementsByClassName("experiencia-form");
    for (let i = 0; i < empresas.length; i++) {
        if (empresas[i].id == id) {
            empresas[i].getElementsByTagName("input")[0].value = "";
            empresas[i].getElementsByTagName("input")[1].value = "";
        }
    }

}

function salvar_experiencia(id) {
    experiencia = [];
    var empresas = document.getElementsByClassName("experiencia-form");
    for (let i = 0; i < empresas.length; i++) {
        if (document.getElementsByName("experiencia")[i].id == id) {
            if (empresas[i].getElementsByTagName("input")[0].value != "" && empresas[i].getElementsByTagName("input")[1].value != "") {
                experiencia.push([empresas[i].getElementsByTagName("input")[0].value, empresas[i].getElementsByTagName("input")[1].value]);
                document.getElementsByName("experiencia")[i].value = JSON.stringify(experiencia);
            } else {
                alert("Empresa ou Cargo não informado");
            }
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

function adicionar_experiencia(id, user) {
    var tabela = document.getElementsByClassName("experiencias")[id];
    tabela.innerHTML +=
        `
        <tr id="` + (tabela.children.length + 1) + `" class="experiencia-form">
            <th>
                <div style="display: flex; flex-direction: column;">
                    <label>Empresa</label>
                    <input type="text" placeholder="Empresa" />
                    <label>Cargo</label>
                    <input type="text" placeholder="Cargo" />
                    <div class="botoes">
                        <input readonly onclick="limpar_experiencia(` + (tabela.children.length + 1) + `)" class="button action" name="limpar" value="Limpar" />
                        <input readonly onclick="remover_experiencia(` + (tabela.children.length + 1) + `)" class="button action" name="excluir" value="Excluir" />
                    </div>
                    <input type="hidden" class="experiencia" name="experiencia" id="` + user + `">
                </div>
            </th>
        </tr>
        `;
}

function fecharPopup(){
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        fecharPopup();
    }
}

function mostrarPopup(id) {
    if (id.includes("-foto-editar")) {
        foto = document.getElementById(id);
        if (foto.style.display == "none") {
            foto.style.display = "flex";
        } else {
            foto.style.display = "none";
        }
    } else {
        modal = document.getElementById(id);
        if (modal.style.display == "none") {
            modal.style.display = "block";
        } else {
            modal.style.display = "none";
        }
    }
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
