<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Momento = new Momento($_GET['Momento'],NULL,NULL);
    echo ConsultarPartesDeMomento($Momento);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>