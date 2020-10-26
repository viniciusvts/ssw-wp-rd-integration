<?php
function ssw_wprdi_callbackcoderd () {
  $RDI = new Rdi_wp();
  $url = SSW_WPRDI_URLHOME;
  if($RDI->setCode($_GET['code'])){
    wp_redirect($url);
    exit;
  }else{
    wp_redirect($url);
    exit;
  }
}
/**
 * Função registra os endpoints
 * @author Vinicius de Santana
 */
function ssw_wprdi_registerapi(){
    $sswuriapi = 'ssw-wp-rd-integration/v1';
    //contato footer
    register_rest_route($sswuriapi,
      '/callback-code-rd',
      array(
        'methods' => 'GET',
        'callback' => 'ssw_wprdi_callbackcoderd',
        'description' => 'recebe as informações do form e envia um email notificando o adm do site',
      )
    );
}
  
  add_action('rest_api_init', 'ssw_wprdi_registerapi');
  