<?php

function sna_cadastros()
{
    global $wpdb;
    $sql = "SELECT * FROM sna_usuarios";
    $usuarios = $wpdb->get_results($sql);
?>
    <div style="float: left; margin-top: 15px; padding: 0;">
        <h2>Listagem de Cadastros SNA</h2>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Criado</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Experiencias</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usuarios as $i => $usuario) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $usuario->id; ?></th>
                        <th><?php echo $usuario->criado; ?></th>
                        <th><?php echo $usuario->nome; ?></th>
                        <th><?php echo $usuario->email; ?></th>
                        <th><?php echo $usuario->cpf; ?></th>
                        <th>
                            <?php
                            $experiencias = unserialize($usuario->experiencias);
                            if (isset($experiencias) && $experiencias != "" && $experiencias != " " && $experiencias != null) {
                                $experiencias = unserialize($usuario->experiencias);
                                foreach ($experiencias as $experiencia) {
                            ?>
                                    <?php echo "Empresa: " . $experiencia[0] ?>
                                    <?php echo "Cargo: " . $experiencia[1] ?>
                                    <br>
                            <?php
                                }
                            }
                            ?>
                        </th>
                        <th>
                            <a href="javascript:void(0);" onclick="mostrarPopup('<?php echo $usuario->id; ?>-foto')">Ver imagem</a>
                            <div id="<?php echo $usuario->id; ?>-foto" class="modal" style="display: none;">
                                <div class="conteudo-modal">
                                    <span class="fechar">&times;</span>
                                    <img src="<?php echo $usuario->foto; ?>" />
                                </div>
                            </div>
                        </th>
                        <th>
                            <form method="post" enctype="multipart/form-data">
                                <button type="button" class="button action" onclick="mostrarPopup('<?php echo $usuario->id; ?>-edit'); salvar_experiencia('<?php echo $usuario->id; ?>')">Editar</button>
                                <input type="submit" class="button action" name="deletar" value="Deletar" />
                                <div id="<?php echo $usuario->id; ?>-edit" class="modal" style="display: none;">
                                    <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
                                    <input type="hidden" name="fotoAntiga" value="<?php echo $usuario->foto; ?>">
                                    <div class="conteudo-modal" style="display: flex; flex-direction: column;">
                                        <span class="fechar">&times;</span>
                                        <label>Nome</label>
                                        <input type="text" required name="nome" value="<?php echo $usuario->nome; ?>" placeholder="Nome completo" />
                                        <label>Email</label>
                                        <input type="email" required name="email" value="<?php echo $usuario->email; ?>" placeholder="Email" />
                                        <label>CPF</label>
                                        <input type="text" required oninput="mascara(this)" name="cpf" value="<?php echo $usuario->cpf; ?>" placeholder="CPF onze dígitos" />
                                        <table class="wp-list-table widefat striped experiencia">
                                            <thead>
                                                <tr>
                                                    <th class="table-header">
                                                        <a>Experiência profissional</a>
                                                        <a onclick="adicionar_experiencia(<?php echo $i; ?>, <?php echo $usuario->id; ?>)">Adicionar</a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="experiencias">
                                                <?php
                                                $experiencias = unserialize($usuario->experiencias);
                                                if (isset($experiencias) && $experiencias != "") {
                                                    foreach ($experiencias as $i => $experiencia) {
                                                ?>
                                                        <tr id="<?php echo $i; ?>" class="experiencia-form">
                                                            <th>
                                                                <div style="display: flex; flex-direction: column;">
                                                                    <label>Empresa</label>
                                                                    <input type="text" value="<?php echo $experiencia[0]; ?>" placeholder="Empresa" />
                                                                    <label>Cargo</label>
                                                                    <input type="text" value="<?php echo $experiencia[1]; ?>" placeholder="Cargo" />
                                                                    <div class="botoes">
                                                                        <input readonly onclick="limpar_experiencia('<?php echo $i; ?>')" class="button action" name="limpar" value="Limpar" />
                                                                        <input readonly onclick="remover_experiencia('<?php echo $i; ?>')" class="button action" name="excluir" value="Excluir" />
                                                                    </div>
                                                                    <input type="hidden" class="experiencia" name="experiencia" id="<?php echo $usuario->id;; ?>">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        <input readonly onclick="salvar_experiencia('<?php echo $usuario->id; ?>')" class="button action" name="salvar" value="Salvar" />
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <label>Foto do documento</label>
                                        <input type="file" name="foto" />
                                        <input type="submit" type="submit" class="button action" name="editar" value="Editar" />
                                    </div>
                                </div>
                            </form>
                        </th>
                    </tr>
                <?php
                }
                ?>
                <?php
                if (isset($_POST['deletar'])) {
                    $foto = str_replace(rtrim(get_site_url(), '/') . '/', ABSPATH, $usuario->foto);
                    $wpdb->get_results("DELETE FROM sna_usuarios WHERE id=$usuario->id");
                    unlink($foto);
                }
                ?>
                <style>
                    .table-header {
                        display: flex;
                        justify-content: space-between;
                    }

                    .experiencia {
                        margin-top: 10px !important;
                        margin-bottom: 10px;
                    }

                    .botoes>input[type="text"],
                    .botoes>input[type="email"] {
                        padding: 0 8px !important;
                        margin: 0 !important;
                    }

                    .botoes>input[type="file"] {
                        padding: 4px 0 !important;
                        margin: 0 !important;
                    }

                    .botoes>input[type="submit"] {
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

                    tfoot>tr>th>input {
                        width: 100%;
                        text-align: center;
                        background-color: blue;
                    }

                    .modal {
                        position: fixed;
                        align-content: center;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        overflow: auto;
                        background-color: rgba(0, 0, 0, 0.4);
                    }

                    .conteudo-modal {
                        position: fixed;
                        top: 20%;
                        left: 50%;
                        background-color: #fefefe;
                        padding: 30px;
                    }

                    .fechar {
                        color: #aaaaaa;
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        font-size: 28px;
                        font-weight: bold;
                    }

                    .fechar:hover,
                    .fechar:focus {
                        color: #000;
                        text-decoration: none;
                        cursor: pointer;
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
                </style>
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
                                } catch (e) {}
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

                    span = document.getElementsByClassName("fechar");

                    Array.prototype.filter.call(span, function(span) {
                        span.onclick = function() {
                            modal.style.display = "none";
                        }
                    });

                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }

                    function mostrarPopup(id) {
                        modal = document.getElementById(id);
                        if (modal.style.display == "none") {
                            modal.style.display = "block";

                        } else {
                            modal.style.display = "none";
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
                </script>
            </tbody>
        </table>
    </div>
<?php
}
?>