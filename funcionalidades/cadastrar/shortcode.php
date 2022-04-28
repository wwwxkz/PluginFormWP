<?php 

function sna_cadastrar_shortcode()
{
    $retorno = '
    <form method="post" action="script.php" enctype="multipart/form-data">
        <div style="display: flex; flex-direction: column;">
            <label>Nome</label>
            <input type="text" required name="nome" placeholder="Nome completo" />
            <label>Email</label>
            <input type="email" required name="email" placeholder="Email" />
            <label>CPF</label>
            <input type="text" required oninput="mascara(this)" name="cpf" placeholder="CPF onze dígitos" />
            <input type="text" name="experiencia" id="experiencia" style="display:none;" />
            <div class="experiencia">
                <div class="experiencia-header">
                    <a>Experiência profissional</a>
                    <a onclick="adicionar_experiencia()">Adicionar</a>
                </div>
                <div id="experiencias">

                </div>
                <div>
                    <input readonly style="text-align: center; width: 100%; margin-top:10px;" onclick="salvar_experiencia()" class="button action" name="salvar" value="Salvar" />
                </div>
            </div>
            <label for="foto">Foto do documento</label>
            <input type="file" name="foto" />
            <input type="submit" required class="button action" name="cadastrar" value="Cadastrar" />
        </div>
    </form>
	<script>
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
                    } catch (e) {}
                    empresas[i].remove();
                }
            }
        }

        function adicionar_experiencia() {
            var tabela = document.getElementById("experiencias");
            var id = tabela.children.length;
            tabela.innerHTML +=
                `
            <div id="` + id + `" class="experiencia-form">
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
            </div>
            `;
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
    </script>
    <style>
        table {
            margin-top: 20px !important;
        }

        .experiencia-header {
            display: flex;
            justify-content: space-between;
        }

        .experiencia {
            margin-top: 10px !important;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"] {
            padding: 0 8px !important;
            margin: 0 !important;
        }

        input[type="file"] {
            padding: 4px 0 !important;
            margin: 0 !important;
        }

        input[type="submit"] {
			font-size: inherit !important;
			width: 100%;
            margin-top: 10px !important;
        }

        .botoes {
            display: flex;
        }

        .botoes>input {
            margin-top: 10px !important;
            flex-grow: 1;
            text-align: center;
        }

        .botoes>input:not(:last-child) {
            margin-right: 5px;
        }
    </style>
	';

    return $retorno;
}
