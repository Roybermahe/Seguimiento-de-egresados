<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Partes = new Partes($_POST['Codigo'],NULL,NULL,$_POST['Info']);
    echo ActualizarInfoParte($Partes);
?>