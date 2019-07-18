<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Pregunta = new Pregunta($_POST['Codigo'],NULL,$_POST['NuevaDescripcion'],NULL,NULL,NULL);
    echo ActualizarPregunta($Pregunta);
?>