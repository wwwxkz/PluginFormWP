<?php
require_once(CADASTRO_LOCAL . 'funcionalidades/cadastrar/html.php');
require_once(CADASTRO_LOCAL . 'funcionalidades/cadastrar/script.php');
require_once(CADASTRO_LOCAL . 'funcionalidades/cadastrar/shortcode.php');
add_shortcode('sna_cadastrar', 'sna_cadastrar_shortcode');
add_action('admin_menu', 'cadastrar_formulario');
add_action('template_redirect', 'cadastrar_formulario');
?>