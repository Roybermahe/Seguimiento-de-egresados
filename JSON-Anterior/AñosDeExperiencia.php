<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Experiencia = array();
    for($i=1;$i<37;$i++){
        array_push($Experiencia,$i);
    }
    echo json_encode($Experiencia);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>