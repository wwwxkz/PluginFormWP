<?php

function sna_cadastrar()
{
?>
    <table class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th>Cadastro</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    <form method="post" enctype="multipart/form-data">
                        <div style="display: flex; flex-direction: column;">
                            <label>Nome</label>
                            <input type="text" required name="nome" placeholder="Nome completo" />
                            <label>Email</label>
                            <input type="email" required name="email" placeholder="Email" />
                            <label>CPF</label>
                            <input type="text" required oninput="mascara(this)" name="cpf" placeholder="CPF onze dígitos" />
                            <input type="text" name="experiencia" id="experiencia" style="display:none;" />
                            <table class="wp-list-table widefat striped experiencia">
                                <thead>
                                    <tr>
                                        <th class="table-header">
                                            <a>Experiência profissional</a>
                                            <a onclick="adicionar_experiencia()">Adicionar</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="experiencias">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <input readonly onclick="salvar_experiencia()" class="button action" name="salvar" value="Salvar" />
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                            <label for="foto">Foto do documento</label>
                            <input type="file" name="foto" />
                            <input type="submit" required class="button action" name="cadastrar" value="Cadastrar" />
                        </div>
                    </form>
                </th>
            </tr>
        </tbody>
    </table>
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
            max-width: 400px;
        }

        .table-header {
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
            margin-top: 10px !important;
        }

        tfoot>tr>th>input {
            width: 100%;
            text-align: center;
            background-color: blue;
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

<?php
}

function sna_cadastrar_shortcode()
{
    $retorno = '
    <form method="post" enctype="multipart/form-data">
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
add_shortcode('sna_cadastrar', 'sna_cadastrar_shortcode');

function cadastrar_formulario()
{
    if (isset($_POST['cadastrar']) || isset($_POST['editar'])) {
        global $wpdb;
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $cpf = str_replace(array('.', '-', ' '), '', $cpf);
        if (isset($_POST['experiencia'])) {
            $experiencias = $_POST['experiencia'];
            $experiencias = str_replace(array('\\'), '', $experiencias);
            $experiencias = json_decode($experiencias, TRUE);
            $experiencias = serialize($experiencias);
        } else {
            $experiencias = "";
        }
        if (strlen($cpf) == 11) {
            $usuarios = $wpdb->get_results("SELECT 1 FROM sna_usuarios WHERE cpf = $cpf;");
            if (isset($usuarios[0]) && $usuarios[0] >= 1 && isset($_POST['cadastrar'])) {
                echo "<script>alert('CPF já cadastrado')</script>";
                return 1;
            } else {
                if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                    function cadastrar_foto($foto)
                    {
                        require_once(ABSPATH . 'wp-admin/includes/file.php');
                        $cadastrarFoto = wp_handle_upload($foto, array('test_form' => false));
                        if ($cadastrarFoto) {
                            if (isset($_POST['fotoAntiga'])) {
                                $fotoAntiga = str_replace(rtrim(get_site_url(), '/') . '/', ABSPATH, $_POST['fotoAntiga']);
                                unlink($fotoAntiga);
                            }
                            return $cadastrarFoto['url'];
                        }
                    }
                    $foto = cadastrar_foto($_FILES['foto']);
                    if (isset($_POST['id'])) {
                        $id = $_POST['id'];
                        $wpdb->replace(
                            'sna_usuarios',
                            array(
                                'id' => $id,
                                'nome' => $nome,
                                'email' => $email,
                                'cpf' => $cpf,
                                'foto' => $foto,
                                'experiencias' => $experiencias
                            )
                        );
                        return 0;
                    } else {
                        $wpdb->replace(
                            'sna_usuarios',
                            array(
                                'nome' => $nome,
                                'email' => $email,
                                'cpf' => $cpf,
                                'foto' => $foto,
                                'experiencias' => $experiencias
                            )
                        );
                        return 0;
                    }
                } else {
                    if (isset($_POST['id'])) {
                        $id = $_POST['id'];
                        $wpdb->replace(
                            'sna_usuarios',
                            array(
                                'id' => $id,
                                'nome' => $nome,
                                'email' => $email,
                                'cpf' => $cpf,
                                'foto' => $_POST['fotoAntiga'],
                                'experiencias' => $experiencias
                            )
                        );
                        return 0;
                    }
                    echo "<script>alert('Usuario inexistente')</script>";
                    return 1;
                }
                echo "<script>alert('Foto não inserida')</script>";
                return 1;
            }
        } else {
            echo "<script>alert('CPF com menos de 11 digitos')</script>";
            return 1;
        }
    }
}
add_action('admin_menu', 'cadastrar_formulario');
add_action('template_redirect', 'cadastrar_formulario');
?>