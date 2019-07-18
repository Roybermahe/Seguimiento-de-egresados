<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Respuesta = new PosiblesRespuestas($_POST['CodRespuesta'],NULL,NULL,NULL,NULL,NULL,NULL,NULL);
    echo EliminarRespuesta($Respuesta); 
?>