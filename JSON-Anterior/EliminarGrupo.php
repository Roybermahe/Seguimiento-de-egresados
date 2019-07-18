<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Grupo = new Grupo($_POST['CodGrupo'],NULL,NULL);
    echo EliminarGrupo($Grupo);
?>