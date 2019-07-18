<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    echo SubSectorDeEmpresa($_POST['Sector']);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>