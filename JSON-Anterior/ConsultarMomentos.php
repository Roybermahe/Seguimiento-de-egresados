<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    echo ConsultarMomentos();
    header('Content-type: Application/json');
    header('Access-Content-Allow-Origin: *');
?>