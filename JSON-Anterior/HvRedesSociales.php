<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    echo HvRedes_Sociales(new HvRedesSociales($_POST['UrlFacebook'],$_POST['UrlTwitter'],$_POST['UrlGoogle']));
?>