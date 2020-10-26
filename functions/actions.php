<?php
//adiocionar admin menu
add_action ('admin_menu', 'mainAdminPage');
// para pegar a url de uma página
/* menu_page_url( string $menu_slug, bool $echo = true ) */
function mainAdminPage()
{
	add_menu_page(
		SSW_WPRDI_PLUGIN_NAME,
		SSW_WPRDI_PLUGIN_NAME,
		'manage_options',
		SSW_WPRDI_PLUGIN_SLUG,
		'returnMainPage',
		'dashicons-admin-settings',
		150
	);
	/*
	add_submenu_page( string $parent_slug, 
					string $page_title, 
					string $menu_title, 
					string $capability, 
					string $menu_slug, 
					callable $function = '', 
					int $position = null )
	*/
	add_submenu_page( 
		SSW_WPRDI_PLUGIN_SLUG, 
		SSW_WPRDI_PLUGIN_NAME.'Configuração', 
		'Configuração', 
		'manage_options',
		SSW_WPRDI_PLUGIN_SLUG.'-config', 
		'returnEditPage', 
		1
	);
}
function returnMainPage(){
	include SSW_WPRDI_PATH."/views/template/index.php";
}
function returnEditPage(){
	include SSW_WPRDI_PATH."/views/template/edit.php";
}