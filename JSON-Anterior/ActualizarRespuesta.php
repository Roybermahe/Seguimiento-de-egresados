<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $PosRespuesta = new PosiblesRespuestas($_POST['CodRespuesta'],$_POST['CodPregunta'],$_POST['Descripcion'],$_POST['Anotacion'],$_POST['PreguntaAsociada'],$_POST['ParteAsociada'],$_POST['Espacio'],$_POST['DirGrupo']);
        echo ActualizarRespuesta($PosRespuesta);
?>