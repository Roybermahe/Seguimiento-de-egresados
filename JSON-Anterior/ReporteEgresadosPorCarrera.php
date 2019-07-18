<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Year = NULL;
    if(isset($_POST['Year'])){
        $Year = $_POST['Year'];
    }
    echo ReporteGeneralEgresadosPorCarrera($Year);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>