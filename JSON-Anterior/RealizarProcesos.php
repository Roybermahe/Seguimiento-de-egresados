<?php
    session_start();
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    echo EliminarPublicacion(new Procesos($_POST['Of'],$_POST['Hv'],$_POST['Np'])); 
?>