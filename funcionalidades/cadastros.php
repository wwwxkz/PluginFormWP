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
                    <th scope="col">Foto</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usuarios as $usuario) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $usuario->id; ?></th>
                        <th><?php echo $usuario->criado; ?></th>
                        <th><?php echo $usuario->nome; ?></th>
                        <th><?php echo $usuario->email; ?></th>
                        <th><?php echo $usuario->cpf; ?></th>
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
                                <button type="button" class="button action" onclick="mostrarPopup('<?php echo $usuario->id; ?>-edit')">Editar</button>
                                <input type="submit" class="button action" name="deletar" value="Deletar" />
                                <div id="<?php echo $usuario->id; ?>-edit" class="modal" style="display: none;">
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
                                        <input type="hidden" name="fotoAntiga" value="<?php echo $usuario->foto; ?>">
                                        <div class="conteudo-modal" style="display: flex; flex-direction: column;">
											<span class="fechar">&times;</span>
                                            <label for="nome">Nome</label>
                                            <input type="text" required name="nome" value="<?php echo $usuario->nome; ?>" placeholder="Nome completo" />
                                            <label for="email">Email</label>
                                            <input type="email" required name="email" value="<?php echo $usuario->email; ?>" placeholder="Email" />
                                            <label for="cpf">CPF</label>
                                            <input type="text" required name="cpf" value="<?php echo $usuario->cpf; ?>" placeholder="CPF onze dígitos" />
                                            <label for="foto">Foto do documento</label>
                                            <input type="file" name="foto" />
                                            <input type="submit" class="button action" name="editar" value="Editar" />
                                        </div>
                                    </form>
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

                </script>
            </tbody>
        </table>
    </div>
<?php
}
?>