<?php
include SSW_WPRDI_PATH."/views/template/header.php";
$RDI = new Rdi_wp();
?>
<h2>Home</h2>
<p>Status da integração:</p>
<?php
if($RDI->hasClientId()){ echo '<p>Client ID ok</p>'; }
else{
    echo '<p>Insira o Client ID. <a href="';
    menu_page_url(SSW_WPRDI_PLUGIN_SLUG.'-config');
    echo '">Aqui</a></p>';
}

if($RDI->hasClientSecret()){ echo '<p>Client Secret ok</p>'; }
else{
    echo '<p>Insira o Client Secret. <a href="';
    menu_page_url(SSW_WPRDI_PLUGIN_SLUG.'-config');
    echo '">Aqui</a></p>';
}

if($RDI->hasCode()){ echo '<p>Autorização ok</p>'; }
else{
    if(!$RDI->hasClientId() || !$RDI->hasClientSecret()){ echo '<p>Código ausente, configure o Client ID/Secret primeiro</p>'; }
    else{ 
        echo '<p>Integração não completada. Antes de iniciar, defina na aplicação do RD a url de callback para: ';
        echo SSW_WPRDI_URLCALLBACK.'</p>';
        //url de integração rd
        $url = 'https://api.rd.services/auth/dialog?client_id=';
        $url .= $RDI->getClientId().'&redirect_uri='.SSW_WPRDI_URLCALLBACK;
        //
        echo '<a target="_blank" href="';
        echo $url;
        echo '">Iniciar integração</a>';
    }
}

include SSW_WPRDI_PATH."/views/template/footer.php";
?>
