<?php
$RDI = new Rdi_wp();
// verifica se há posts para configurar variáveis
if(isset($_POST['client_id'])){ $RDI->setClientId($_POST['client_id']); }
if(isset($_POST['client_secret'])){ $RDI->setClientSecret($_POST['client_secret']); }
if(isset($_POST['code'])){
    $RDI->setCode(''); 
    $RDI->setAccessToken(''); 
    $RDI->setRefreshToken(''); 
}
// inicia a página
include SSW_WPRDI_PATH."/views/template/header.php";
?>
<h1>Configurações</h1>
<p>Essas informações estão no aplicativo criado no RD Station</p>
<!-- Client ID -->
<form method="POST" action="<?php $_SERVER['HTTP_REFERER'] ?>">
    <label for="client_id">Cliente ID</label>
    <input type="text" name="client_id" value="<?php echo $RDI->getClientId() ?>">
    <input type="submit" value="Atualizar">
</form>
<!-- Client Secret -->
<form method="POST" action="<?php $_SERVER['HTTP_REFERER'] ?>">
    <label for="client_secret">Cliente Secret</label>
    <input type="text" name="client_secret" value="<?php echo $RDI->getClientSecret() ?>">
    <input type="submit" value="Atualizar">
</form>
<?php
if($RDI->hasCode()){
?>
<!-- Reset Code -->
<form method="POST" action="<?php $_SERVER['HTTP_REFERER'] ?>">
    <label for="code">Apagar Autorização?</label>
    <input type="hidden" name="code" value="true">
    <input type="submit" value="Apagar">
</form>
<?php
}
?>
<p>
    Informações sobre onde encontrar esse dados 
    <a target="_blank" href="https://appstore.rdstation.com/pt-BR/publisher/">aqui.</a>
</p>
<?php
include SSW_WPRDI_PATH."/views/template/footer.php";
?>