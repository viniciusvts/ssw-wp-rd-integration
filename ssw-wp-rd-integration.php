<?php
/**
 * Plugin Name: SSW Integração com o RD
 * Plugin URI: https://www.santanasolucoesweb.com.br/
 * Description: Dispor de uma classe para envio de conversões ao RDStation
 * Version: 1.0
 * Author: Vinicius de Santana
 * Author URI: https://www.santanasolucoesweb.com.br/
 */
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Informações do app
define('SSW_WPRDI_PATH', dirname( __FILE__ ) );
define('SSW_WPRDI_URL', plugins_url( '', __FILE__ ) );
define('SSW_WPRDI_PLUGIN_NAME', 'SSW RD Integra' );
define('SSW_WPRDI_PLUGIN_SLUG', 'rdi-admin' );
define('SSW_WPRDI_URLHOME', '/wp-admin/admin.php?page='.SSW_WPRDI_PLUGIN_SLUG );
//informações do aplicativo criado no rd
define('SSW_WPRDI_CLIENT_ID', 'ssw_wprdi_client_id');
define('SSW_WPRDI_CLIENTE_SECRET', 'ssw_wprdi_cliente_secret');
define('SSW_WPRDI_URLCALLBACK', site_url().'/wp-json/ssw-wp-rd-integration/v1/callback-code-rd/');
define('SSW_WPRDI_CODE', 'ssw_wprdi_code');
define('SSW_WPRDI_ACCESS_TOKEN', 'ssw_wprdi_access_token');
define('SSW_WPRDI_REFRESH_TOKEN', 'ssw_wprdi_refresh_token');

include_once SSW_WPRDI_PATH.'/class/index.php';
include_once SSW_WPRDI_PATH.'/api/index.php';
include_once SSW_WPRDI_PATH.'/functions/index.php';

register_activation_hook(__FILE__, 'install');
register_uninstall_hook(__FILE__, 'uninstall');
//==================================================================
//funções
/**
 * função de instalação do plugin
 */
function install(){
	add_option(SSW_WPRDI_CLIENT_ID, '');
	add_option(SSW_WPRDI_CLIENTE_SECRET, '');
	add_option(SSW_WPRDI_CODE, '');
	add_option(SSW_WPRDI_ACCESS_TOKEN, '');
	add_option(SSW_WPRDI_REFRESH_TOKEN, '');
}

/**
 * função de desinstalação do plugin
 */
function uninstall(){
	delete_option(SSW_WPRDI_CLIENT_ID);
	delete_option(SSW_WPRDI_CLIENTE_SECRET);
	delete_option(SSW_WPRDI_CODE);
	delete_option(SSW_WPRDI_ACCESS_TOKEN);
	delete_option(SSW_WPRDI_REFRESH_TOKEN);
}