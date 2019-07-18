<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    echo ConsultarNumeroEmpleados();
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>