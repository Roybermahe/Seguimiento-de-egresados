<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $f=0;$g=0;
    if(isset($_POST['Mudarse'])){$f=1;}
    if(isset($_POST['Viajar'])){$g=1;}
    echo HvPerfil_Laboral(new PerfilLaboral(NULL,NULL,$_POST['Profesion'],$_POST['DescPerfil'],$_POST['Experiencia'],$_POST['AspSalarial'],$f,$g));
?>