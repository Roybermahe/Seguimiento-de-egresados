<?php
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    ob_start();
    $Grupo = new Grupo(NULL,$_POST['TituloGrupo'],$_POST['DescripcionGrupo']);
    echo GuardarGrupo($Grupo);
?>