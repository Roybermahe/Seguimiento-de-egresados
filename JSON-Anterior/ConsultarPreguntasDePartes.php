<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Parte = new Partes($_GET['Parte'],NULL,NULL,NULL);
    echo ConsultarPreguntasDePartes($Parte);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>