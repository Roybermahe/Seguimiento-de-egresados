<?php
ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
        $PosRespuesta = new PosiblesRespuestas(NULL,$_POST['CodPregunta'],$_POST['Descripcion'],$_POST['Anotacion'],$_POST['PreguntaAsociada'],$_POST['ParteAsociada'],$_POST['Espacio'],$_POST['DirGrupo']);echo GuardarRespuestas($PosRespuesta);
?>