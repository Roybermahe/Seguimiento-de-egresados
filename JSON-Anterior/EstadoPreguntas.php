<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Estado = new Pregunta($_POST['Codigo'],NULL,NULL,NULL,NULL,$_POST['Estado']);
    echo ActualizarEstado($Estado);
?>