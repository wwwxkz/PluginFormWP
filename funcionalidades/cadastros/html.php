<?php

function sna_cadastros()
{
    global $wpdb;
    $sql = "SELECT * FROM sna_usuarios";
    $usuarios = $wpdb->get_results($sql);
    ?>
    <link rel="stylesheet" href="..\wp-content\plugins\cadastro\funcionalidades\cadastros\style.css">
    <script type="text/javascript" src="..\wp-content\plugins\cadastro\funcionalidades\cadastros\script.js"></script>
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
                            <a href="javascript:void(0);" onclick="mostrarPopup('<?php echo $usuario->id; ?>-foto')">Visualizar</a>
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
                                        <table class="wp-list-table widefat striped experiencia">
                                            <thead>
                                                <tr>
                                                    <th class="table-header">
                                                        <a>Foto</a>
                                                        <a onclick="mostrarPopup('<?php echo $usuario->id; ?>-foto-editar')">Visualizar</a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody style="display:none; justify-content: center;" id="<?php echo $usuario->id; ?>-foto-editar">
                                                <tr>
                                                    <th>
                                                        <img style="object-fit: cover; width: 300px; height: auto;" src="<?php echo $usuario->foto; ?>" />
                                                    </th>
                                                </tr>
                                            </tbody>
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
            </tbody>
        </table>
    </div>
<?php
}
?>