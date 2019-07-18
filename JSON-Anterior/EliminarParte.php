<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Parte = new Partes($_POST['CodParte'],NULL,NULL,NULL);
    echo EliminarParte($Parte);
?>