<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Parte = new Partes(NULL,$_POST['Opcion'],$_POST['Descripcion'],$_POST['Info']);
    echo GuardarParte($Parte);
?>