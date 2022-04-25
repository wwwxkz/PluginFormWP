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
							<label for="nome">Nome</label>
							<input type="text" required name="nome" placeholder="Nome completo" />
							<label for="email">Email</label>
							<input type="email" required name="email" placeholder="Email" />
							<label for="cpf">CPF</label>
							<input type="text" required name="cpf" placeholder="CPF onze dígitos" />
							<label for="foto">Foto do documento</label>
							<input type="file" name="foto" />
							<input type="submit" required class="button action" name="cadastrar" value="Cadastrar" />
						</div>
					</form>
					</th>
				</tr>
			</tbody>
</table>
<style>
	table {
		margin-top: 20px !important;
		max-width: 400px;
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

<?php
}

function sna_cadastrar_shortcode()
{
    $retorno = '
    <div>
        <form method="post" enctype="multipart/form-data">
            <div style="display: flex; flex-direction: column;">
                <label for="nome">Nome</label>
                <input type="text" required name="nome" placeholder="Nome completo" />
                <label for="email">Email</label>
                <input type="email" required name="email" placeholder="Email" />
                <label for="cpf">CPF</label>
                <input type="text" required name="cpf" placeholder="CPF onze dígitos" />
                <label for="foto">Foto do documento</label>
                <input type="file" required name="foto" /><br>
                <input type="submit" class="button action" name="cadastrar" value="Cadastrar" style="font-size: 100% !important;" />
            </div>
        </form>
    </div>
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
                                'foto' => $foto
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
                                'foto' => $foto
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
                                'foto' => $_POST['fotoAntiga']
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