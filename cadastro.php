<?php

/*
Plugin Name: Cadastro SNA
Description: Plugin solicitado pelo teste técnico SNA
Version: 0.8
Author: Marcelo Rodrigues
Author URI: https://github.com/wwwxkz
*/

define('CADASTRO_LOCAL', plugin_dir_path(__FILE__));
require_once(CADASTRO_LOCAL . 'funcionalidades/cadastros/cadastros.php');
require_once(CADASTRO_LOCAL . 'funcionalidades/cadastrar/cadastrar.php');

add_action('admin_menu', 'cadastro');
function cadastro(){
	add_menu_page( 'Cadastro SNA', 'Cadastro SNA', 'manage_options', 'cadastros', 'cadastros', 'dashicons-welcome-widgets-menus', 10 );
	add_submenu_page( 'cadastros', 'Listagem', 'Listagem', 'read', 'sna_cadastros', 'sna_cadastros' );
	add_submenu_page( 'cadastros', 'Novo Cadastro', 'Novo Cadastro', 'read', 'sna_cadastrar', 'sna_cadastrar' );
	remove_submenu_page('cadastros','cadastros');
}		

register_activation_hook(__FILE__, 'ativacao');
function ativacao(){
	global $wpdb;
	$tabela = "sna_usuarios"; 
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $tabela (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		criado timestamp NOT NULL default CURRENT_TIMESTAMP,
		nome tinytext NOT NULL,
		email varchar(255) NOT NULL,
		cpf varchar(255) NOT NULL,
		experiencias varchar(255),
		foto varchar(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

register_uninstall_hook(__FILE__, 'desinstalacao');
function desinstalacao(){
	$tabela = "sna_usuarios"; 
	$sql = "DROP TABLE IF EXISTS $tabela";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}
?>


