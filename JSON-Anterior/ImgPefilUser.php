<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Imagen = new ImgBase64($_POST['img'],$_POST['Base64']);
    GuardarImagenes($Imagen);
?>