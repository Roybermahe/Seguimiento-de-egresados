<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Pregunta = new Pregunta($_GET['p'],NULL,NULL,NULL,NULL,NULL);
    echo ConsultarPosRespuestasDos($Pregunta);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>