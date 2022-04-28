<?php
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
?>